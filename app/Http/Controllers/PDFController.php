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
        return view('material_ui/bill/bills', compact('bills'));
    }

    public function create_billing(){
        return view('pdf/create');
    }

    public function create_billing_post(Request $request){
        $title = $request->title; 
        $amount = $request->amount;
        $created_at = $request->created_at;
            
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

        $title_doc = $project_name;

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

        return redirect('/bills')->with('success', $title_doc.'_'.\Carbon\Carbon::parse($created_at)->format('d/m/Y').' has been billed!');
    }

    public function view_bills($id){
        $project_info = MainProject::where('id', $id)->first();
        $created_at = $project_info['created_at'];
        $title_doc = $project_info['name'];
        $bills = Billing::where('project_id', $id)->get();
        $total_amount = 0;
        $data = [];

        foreach($bills as $bill){
            $total_amount += $bill->amount;

            $array = [
                'title' => $bill->title,
                'amount' => $bill->amount
            ];
            array_push($data, $array);
        }

        $in_words = $this->numberTowords($total_amount);
        $pdf = PDF::loadView('pdf/demo', compact('data', 'total_amount', 'in_words', 'created_at', 'title_doc'));
        return $pdf->download($title_doc.'_'.\Carbon\Carbon::parse($created_at)->format('d/m/Y').'.pdf');
    }

    public function delete_bill($id){
        $main_project_info = MainProject::where('id', $id)->first();

        $billings = Billing::where('project_id', $id)->get();
        foreach($billings as $bill)
        {
            Billing::where('id', $bill->id)->delete();
        }
        MainProject::where('id', $id)->delete();
        return redirect('/bills')->with('danger', $main_project_info['name'].' been deleted along with assets!');
    }

    function numberTowords(float $amount)
    {
        $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
        // Check if there is any number after decimal
        $amt_hundred = null;
        $count_length = strlen($num);
        $x = 0;
        $string = array();
        $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $x < $count_length ) 
        {
            $get_divider = ($x == 2) ? 10 : 100;
            $amount = floor($num % $get_divider);
            $num = floor($num / $get_divider);
            $x += $get_divider == 10 ? 1 : 2;
            if ($amount) 
            {
                $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
                $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
                $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
                '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
                '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
            }
                else 
                $string[] = null;
        }
            $implode_to_Rupees = implode('', array_reverse($string));
            $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
            " . $change_words[$amount_after_decimal % 10]) . '' : '';
            return ($implode_to_Rupees ? $implode_to_Rupees . '' : '') . $get_paise;
    }
}
