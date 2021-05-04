<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Session;
use App\User;
use App\Transfer;
use App\SubTransfer;
use App\Helper\Helper;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = Transfer::orderBy('created_at', 'DESC')->get();
        return view('transfer.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transfer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'upload' => 'required',
            'upload.*' => 'mimes:zip'
        ]);

        $slug = time();
        $dateTime = date("Y-m-d H:i:s");

        $transfer_id = Transfer::insertGetId([
            'name' => $request->name,
            'client_name' => $request->client_name,
            'uploader' => Auth::user()->id,
            'slug' => $slug,
            'created_at' => $dateTime,
        ]);

        if($request->hasfile('upload'))
        {
            foreach($request->file('upload') as $file)
            {
                $path = public_path().'/transfer_files/'.$slug;
                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }

                $file_name = $file->getClientOriginalName();
                $file->move($path, $file_name);
                $data[] = $file_name;

                SubTransfer::insert([
                    'transfer_id' => $transfer_id,
                    'path' => $file_name,
                    'created_at' => $dateTime,
                ]);
            }
        }

        return redirect('/p9_transfer/'.$slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slug = $id;
        $transfer = Transfer::where('slug', $slug)->first();
        $name = $transfer['name'];
        $client_name = $transfer['client_name'];
        if($transfer == NULL)
        {
            return view('404');
        }
        else
        {
            $sub_transfers = SubTransfer::where('transfer_id', $transfer['id'])->get();
            return view('transfer.show', compact(
                'sub_transfers', 
                'slug',
                'name'
            ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transfer = Transfer::find($id);
        $transfer_name = $transfer['name'];
        $transfer_client_name = $transfer['client_name'];
        return view('transfer.edit', compact('transfer_name', 'transfer_client_name', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'upload.*' => 'mimes:zip'
        ]);

        $transfer = Transfer::find($id);
        $slug = $transfer['slug'];
        $transfer_id = $id;
        $created_at = $transfer['created_at'];
        $dateTime = date("Y-m-d H:i:s");

        $data = [
            'name' => $request->name,
            'client_name' => $request->client_name,
            'updated_at' => $dateTime
        ];

        Transfer::where('id', $transfer_id)->update($data);

        $sub_transfers = SubTransfer::where('transfer_id', $transfer_id)->get();

        if($request->hasfile('upload'))
        {
            foreach($sub_transfers as $item)
            {
                $directory = public_path().'/transfer_files/'.$slug;
                unlink('transfer_files/'.$slug.'/'.$item->path);
            }
            SubTransfer::where('transfer_id', $transfer_id)->delete();

            $sub_data = array();
            foreach($request->file('upload') as $file)
            {
                $path = public_path().'/transfer_files/'.$slug;
                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }

                $file_name = $file->getClientOriginalName();
                $file->move($path, $file_name);
                $info[] = $file_name;

                $data = [
                    'transfer_id' => $transfer_id,
                    'path' => $file_name,
                    'created_at' => $created_at,
                    'updated_at' => $dateTime
                ];
                array_push($sub_data, $data);
            }
            Subtransfer::insert($sub_data);
        }
        return redirect('/p9_transfer')->with('success', $request->name . ' has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubTransfer::where('transfer_id', $id)->delete();

        $transfer = Transfer::find($id);
        $directory = public_path().'/transfer_files/'.$transfer->slug;
        File::deleteDirectory($directory);
        Transfer::where('id', $id)->delete();
        return redirect('/p9_transfer')->with('danger', 'Transfer link been deleted along with files!');
    }

    public function download_all($slug)
    {
        $transfer = Transfer::where('slug', $slug)->first();
        $transfer_id = $transfer['id'];

        $files = SubTransfer::where('transfer_id', $transfer_id)->get();
        
        $file_path = public_path().'/transfer_files/'.$slug;
        $zip = new ZipArchive();
        $zip_name = 'Planetnine_Transfer_'.$slug.".zip";
        $zip->open($zip_name, ZipArchive::CREATE);

        foreach($files as $file)
        {
            $path = public_path().'/transfer_files/'.$slug.'/'.$file['path'];
            if(file_exists($path))
            {
                $zip->addFromString(basename($path),  file_get_contents($path));
            }
            else
            {
                dd('File Not Found');
            }
        }
        $headers = ['Content-Type: application/pdf'];

        $zip->close();

        return response()->download($zip_name)->deleteFileAfterSend(true);
    }
}
