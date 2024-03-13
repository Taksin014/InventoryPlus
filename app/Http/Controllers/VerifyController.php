<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Bill;
use App\Models\BillAdd;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Item;
use App\Models\Agencies;
use App\Models\Department;
use App\Models\Reason;
use App\Models\User;
use App\Models\Account;


class VerifyController extends Controller
{
        /** page bills */
        public function VerifyIndex()
        {
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $reasons     = DB::table('reasons')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
            $accounts     = DB::table('accounts')->get();
            $bills     = DB::table('bills')
            ->join('users', 'bills.user_id', '=', 'users.user_id')
            ->join('agencies', 'bills.age_id', '=', 'agencies.age_id')
            ->select('bills.*','users.*','agencies.*')
            ->get();
            $billJoin  = DB::table('bills')
                ->join('bill_adds', 'bills.bill_number', '=', 'bill_adds.bill_number')
                ->join('items', 'bill_adds.item_id', '=', 'items.item_id')
                ->join('departments', 'bill_adds.depart_id', '=', 'departments.depart_id')
                ->select('bills.*', 'bill_adds.*','items.*','departments.*')
                ->get();
            return view('verify.verifys',compact('bills','billJoin','items','agencies','departments','users','reasons','accounts'));
        }

        public function Verify_historyIndex()
        {
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
            $reasons     = DB::table('reasons')->get();
            $accounts     = DB::table('accounts')->get();
            $bills     = DB::table('bills')
            ->join('users', 'bills.user_id', '=', 'users.user_id')
            ->join('agencies', 'bills.age_id', '=', 'agencies.age_id')
            ->select('bills.*','users.*','agencies.*')
            ->get();
            $billJoin  = DB::table('bills')
                ->join('bill_adds', 'bills.bill_number', '=', 'bill_adds.bill_number')
                ->join('items', 'bill_adds.item_id', '=', 'items.item_id')
                ->join('departments', 'bill_adds.depart_id', '=', 'departments.depart_id')
                ->select('bills.*', 'bill_adds.*','items.*','departments.*')
                ->get();
            return view('verify.verify_history',compact('bills','billJoin','items','agencies','departments','users','reasons','accounts'));
        }

        public function VerifiedView($bill_line_id)
        { 

            $billJoin    = DB::table('bill_adds') ->where('bill_line_id',$bill_line_id)->first();
            return view('verify.VerifiedView',compact('billJoin'));

        }


        public function updateVerified(Request $request)
        {
            DB::beginTransaction();
        try {
           
            $update = [
                    'bill_line_id' => $request->bill_line_id,
                    // 'bill_number' => $request->bill_number,
                    'item_id' => $request->item_id,
                    'depart_id' => $request->depart_id,
                    'qty' => $request->qty,
                    'desc' => $request->desc,
                    'state' => $request->state,
                    'verify' => $request->verify,
                    'reason_code'=> $request->reason_code,
                    'segment_desc'=> $request->segment_desc,
                    'acc_desc'=> $request->acc_desc,
                    'segment'=> $request->segment,
                    'chart'=> $request->chart, 
            ];

            // dd($request->all(),  $request->bill_line_id);
            BillAdd::where('bill_line_id',$request->bill_line_id )->update($update);
            
            DB::commit();
            Toastr::success('อัพเดทบิลสำเร็จ :)', 'สำเร็จ');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Error updating the bill: ' . $e->getMessage());
            // Toastr::error('การอัพเดทบิลล้มเหลว :(', 'ข้อผิดพลาด');
            return redirect()->back();
        } 
        } 


        // public function getSegment1Desc(Request $request)
        // {
        //     $segment1 = $request->input('segment1');
    
        //     // ค้นหา SEGMENT1_DESC จากตาราง accounts
        //     $account = Account::where('SEGMENT1', $segment1)->first();
    
        //     if ($account) {
        //         return response()->json(['success' => true, 'segment1_desc' => $account->SEGMENT1_DESC]);
        //     } else {
        //         return response()->json(['success' => false, 'message' => 'ไม่พบ SEGMENT1 ที่ตรงกัน']);
        //     }
        // }

        public function getSegmentDesc(Request $request)
        {
            $segment3Value = $request->input('segment3');
            $segment4Value = $request->input('segment4');
            $segment5Value = $request->input('segment5');
            $segment6Value = $request->input('segment6');
            $segment7Value = $request->input('segment7');
            // Fetch the corresponding SEGMENT1_DESC from the 'accounts' table
            $segmentDesc3 = Account::where('SEGMENT3', $segment3Value)->value('SEGMENT3_DESC');
            $segmentDesc4 = Account::where('SEGMENT4', $segment4Value)->value('SEGMENT4_DESC');
            $segmentDesc5 = Account::where('SEGMENT5', $segment5Value)->value('SEGMENT5_DESC');
            $segmentDesc6 = Account::where('SEGMENT6', $segment6Value)->value('SEGMENT6_DESC');
            $segmentDesc7 = Account::where('SEGMENT7', $segment7Value)->value('SEGMENT7_DESC');
            return response()->json(['segment_desc3' => $segmentDesc3 , 'segment_desc4' => $segmentDesc4 ,'segment_desc5' => $segmentDesc5 ,
            'segment_desc6' => $segmentDesc6,'segment_desc7' => $segmentDesc7]);
        }




    public function checkMatchingRow(Request $request)
        {
            // Retrieve segment values from the AJAX request
            $segment3 = $request->input('segment3');
            $segment4 = $request->input('segment4');
            $segment5 = $request->input('segment5');
            $segment6 = $request->input('segment6');
            $segment7 = $request->input('segment7');

            // Query the database to find a matching row
            $matchingRow = Account::where('SEGMENT3', $segment3)
                ->where('SEGMENT4', $segment4)
                ->where('SEGMENT5', $segment5)
                ->where('SEGMENT6', $segment6)
                ->where('SEGMENT7', $segment7)
                ->first();

            // Check if a matching row was found
            if ($matchingRow) {
                $matchingRow->update(['CHART_OF_ACCOUNTS_ID' => $matchingRow->CHART_OF_ACCOUNTS_ID]);
                // Return the CHART_OF_ACCOUNTS_ID to the client
                return response()->json(['chartOfAccountsId' => $matchingRow->CHART_OF_ACCOUNTS_ID]);
            } else {
                // Handle the case where no matching row was found
                return response()->json(['chartOfAccountsId' => null]);
            }
        }


    
    public function getReason(Request $request)
    {
        $reason_Value = $request->input('reason_code');
        // Fetch the corresponding SEGMENT1_DESC from the 'accounts' table
        $reason_Desc = Reason::where('reason_code', $reason_Value)->value('reason_name');
        return response()->json(['reason_desc' => $reason_Desc]);
    }






                /** search record */
        public function searchRecord(Request $request)
            {
                $data = DB::table('bills')->get();

                // search by item name
                if(!empty($request->item_name) && empty($request->from_date) && empty($request->to_data))
                {
                    $data = Expense::where('item_name','LIKE','%'.$request->item_name.'%')->get();
                }

                // search by from_date to_data
                if(empty($request->item_name) && !empty($request->from_date) && !empty($request->to_date))
                {
                    $data = Expense::whereBetween('purchase_date',[$request->from_date, $request->to_date])->get();
                }
                
                // search by item name and from_date to_data
                if(!empty($request->item_name) && !empty($request->from_date) && !empty($request->to_date))
                {
                    $data = Expense::where('item_name','LIKE','%'.$request->item_name.'%')
                                    ->whereBetween('purchase_date',[$request->from_date, $request->to_date])
                                    ->get();
                }

                return view('sales.expenses',compact('data'));
            }
    
}
