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


class DispenserController extends Controller
{
        /** page bills */
        public function DispenseIndex()
        {
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
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
            return view('dispense.dispenses',compact('bills','billJoin','items','agencies','departments','users'));
        }

        public function Dispense_historyIndex()
        {
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
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
            return view('dispense.dispenses_history',compact('bills','billJoin','items','agencies','departments','users'));
        }
        
    


        public function DispenseView($bill_line_id)
        { 

            $billJoin    = DB::table('bill_adds') ->where('bill_line_id',$bill_line_id)->first();
            return view('dispense.DispenseView',compact('billJoin'));

        }


        public function updateDispense(Request $request)
        {
            DB::beginTransaction();
        try {
           
            $update = [
                    'bill_line_id' => $request->bill_line_id,
                    'investor' => $request->investor,
                    'receiver' => $request->receiver,
                    'dispense' => $request->dispense,
                    // 'bill_number' => $request->bill_number,
                    // 'item_id' => $request->item_id,
                    // 'depart_id' => $request->depart_id,
                    // 'qty' => $request->qty,
                    // 'desc' => $request->desc,
                    // 'state' => $request->state,
                    // 'verify' => $request->verify,
                    // 'reason_code'=> $request->reason_code,
                    // 'segment_desc'=> $request->segment_desc,
                    // 'acc_desc'=> $request->acc_desc,
                    // 'segment'=> $request->segment,
                    // 'chart'=> $request->chart,
                    // 'chart_desc'=> $request->chart_desc,
                    // 'bill_date'=> $request->bill_date,
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




        public function SucceedBill($bill_number, Request $request)
        {
            $request->validate([
                'investor' => 'required',
                'receiver' => 'required',
            ]);

            // Retrieve the bill based on the provided bill number
            $bill = Bill::where('bill_number', $bill_number)->first();

            // Check if the bill is found
            if (!$bill) {
                return response()->json(['error' => 'Bill not found'], 404);
            }

            // Check if both investor and receiver are provided in the request
            if ($request->has('investor') && $request->has('receiver')) {
                // Update the bill details
                $bill->investor = $request->input('investor');
                $bill->receiver = $request->input('/* The `receiver` is a field in the `Bill` model
                that represents the person who receives the bill.
                In the `SucceedBill` method, it is being updated
                with the value provided in the request. */
                receiver');
                $bill->dispense = 'Succeed'; // Assuming you want to update the "dispense" field
                $bill->save();

                return response()->json(['message' => 'Bill succeed successfully']);
            } else {
                return response()->json(['error' => 'Investor and Receiver are required'], 422);
            }
        }
                    
        public function FailBill($bill_number)
        {
            $bill = Bill::where('bill_number', $bill_number)->first();

                if (!$bill) {
                    return response()->json(['error' => 'Bill not found'], 404);
                }
                $bill->dispense = 'Fail';
                $bill->save();

                return response()->json(['message' => 'Bill Fail successfully']);
        }

        /** update record trainers */
        // public function SucceedBill(Request $request) 
        // {
        //     DB::beginTransaction();
        //     try {
        //         $update = [
        //             'id'      => $request->id,
        //             'dispense' => 'Succeed',
        //             'investor' => $request->investor,
        //             'receiver' => $request->receiver,
        //         ];
        //         // Debugging to check the value of 'bill_number'
        //         // dd($update);
        
        //         // Update the 'Bill' record based on 'bill_number'
        //         Bill::where('id', $request->id)->update($update);
        
        //         DB::commit();
        //         Toastr::success('Updated Bill successfully :)', 'Success');
        //         return redirect()->back();
        //     } catch(\Exception $e) {
        //         DB::rollback();
        //         Toastr::error('Update Bill fail :(', 'Error');
        //         return redirect()->back();
        //     }
        // }

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
