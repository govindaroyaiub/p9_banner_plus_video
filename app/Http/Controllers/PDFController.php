<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\User;
use App\MainProject;
use App\Billing;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function billing_list(){
        $bills = MainProject::where('project_type', 5)->orderBy('created_at', 'DESC')->get();
        return view('pdf/billing_list', compact('bills'));
    }

    public function create_billing(){
        return view('pdf/create');
    }

    public function create_billing_post(Request $request){
        $title = $request->title; 
        $amount = $request->amount;
            
        $pro_name = $request->project_name;
        $project_name = str_replace(" ", "_", $request->project_name);
        $main_project = new MainProject;
        $main_project->name = $pro_name;
        $main_project->client_name = $request->client_name;
        $main_project->logo_id = $request->logo_id;
        $main_project->color = $request->color;
        $main_project->is_logo = 1;
        $main_project->is_footer = 1;
        $main_project->project_type = 5;
        $main_project->is_version = 0;
        $main_project->uploaded_by_user_id = Auth::user()->id;
        $main_project->uploaded_by_company_id = Auth::user()->company_id;
        $main_project->created_at = $request->created_at;
        $main_project->save();

        $total_amount = 0;

        foreach($title as $index => $item)
        {
            $total_amount = $total_amount + $amount[$index];
            $billing = new Billing;
            $billing->title = $item;
            $billing->amount = $amount[$index];
            $billing->project_id = $main_project->id;
            $billing->save();
        }

        $data = Billing::where('project_id', $main_project->id)->get();
        $pdf = PDF::loadView('pdf/demo', compact('data'))->save('demo.pdf');
  
        return $pdf->download('demo.pdf');
    }

    public function generatePDF()
    {
        $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        $pdf = PDF::loadView('pdf/myPDF', $data);
  
        return $pdf->download('itsolutionstuff.pdf');
    }

    public function generatePDF2()
    {
        $data = ['title' => 'Welcome to ItSolutionStuff.com'];
        $pdf = PDF::loadView('pdf/myPDF', $data);
  
        return $pdf->download('itsolutionstuff.pdf');
    }
}
