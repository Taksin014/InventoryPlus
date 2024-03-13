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
use App\Models\User;


class ApproverController extends Controller
{
        /** page bills */
        public function ApproverIndex()
        {   
            // $bills = Bill::all();
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
            // $bills     = DB::table('bills')->get();
            $bills     = DB::table('bills')
            ->join('users', 'bills.user_id', '=', 'users.user_id')
            ->join('agencies', 'bills.age_id', '=', 'agencies.age_id')
            ->select('bills.*','users.*','agencies.*' )
            ->get();
            // dd($bills);
            $billJoin  = DB::table('bills')
                ->join('bill_adds', 'bills.bill_number', '=', 'bill_adds.bill_number')
                ->join('items', 'bill_adds.item_id', '=', 'items.item_id')
                ->join('departments', 'bill_adds.depart_id', '=', 'departments.depart_id')
                ->select('bills.*', 'bill_adds.*','items.*','departments.*', 'items.item_id', 'items.item_name')
                ->get();
            return view('approver.approvers',compact('bills','billJoin','items','agencies','departments','users'));
        }

        public function HistoryIndex()
        {   
            // $bills = Bill::all();
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
            // $bills     = DB::table('bills')->get();
            $bills     = DB::table('bills')
            ->join('users', 'bills.user_id', '=', 'users.user_id')
            ->join('agencies', 'bills.age_id', '=', 'agencies.age_id')
            ->select('bills.*','users.*','agencies.*')
            ->get();
            // dd($bills);
            $billJoin  = DB::table('bills')
                ->join('bill_adds', 'bills.bill_number', '=', 'bill_adds.bill_number')
                ->join('items', 'bill_adds.item_id', '=', 'items.item_id')
                ->join('departments', 'bill_adds.depart_id', '=', 'departments.depart_id')
                ->select('bills.*', 'bill_adds.*','items.*','departments.*')
                ->get();
            return view('approver.permission_history',compact('bills','billJoin','items','agencies','departments','users'));
        }
        
        public function ApproverView($bill_number)
        { 

            $bills    = DB::table('bills') ->where('bill_number',$bill_number)->first();
            $billJoin = DB::table('bills')
                ->join('bill_adds', 'bills.bill_number', '=', 'bill_adds.bill_number')
                ->select('bills.*', 'bill_adds.*')
                ->where('bill_adds.bill_number',$bill_number)
                ->get();
            return view('approver.ApproverView',compact('bills','billJoin'));

        }

        public function updateApprover(Request $request)
        {
            DB::beginTransaction();
        try {
           
            $update = [
                'bill_id'                => $request->bill_id,
                'state'                  => $request->state,
            ];

            // dd($request->all(),  $request->bill_id,$request->bill_adds );
            Bill::where('bill_id',$request->bill_id )->update($update);
            
            foreach ($request->bill_adds as $key => $items) {
                DB::table('bill_adds')->where('bill_line_id',$request->bill_adds[$key])->delete();
            }

            foreach ($request->item_id as $key => $item) {
                $BillAdd = [
                    'bill_number' => $request->bill_number,
                    'item_id' => $request->item_id[$key],
                    'depart_id' => $request->depart_id[$key],
                    'qty' => $request->qty[$key],
                    'desc' => $request->desc[$key],
                    'state' => $request->state,
                ];
                BillAdd::create($BillAdd);
            }
            
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

                /** search record */
    public function searchApprover(Request $request)
    {
        $bills = DB::table('bills')->get();

        // search by item name
        if(!empty($request->bill_date) && empty($request->state))
        {
            $bills = Bill::where('bill_date','LIKE','%'.$request->bill_date.'%')->get();
        }

        // search by from_date to_data

        if(empty($request->bill_date) && !empty($request->state))
        {
            $bills = Bill::where('state','LIKE','%'.$request->state.'%')->get();
        }
        
        // search by item name and from_date to_data
        if(!empty($request->bill_date) && !empty($request->state))
        {
            $bills = Bill:: where('bill_date','LIKE','%'.$request->bill_date.'%')
                            ->where('state','LIKE','%'.$request->state.'%')
                            ->get();
        }

        return view('approver.search',compact('bills'));
    }

}

