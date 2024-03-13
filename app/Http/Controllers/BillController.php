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
use Session;
use Auth;



class BillController extends Controller
{
        /** page bills */
        public function billsIndex()
        {
            $id = Auth::User()->id;
            Session::put('acc_id', $id);

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
            return view('bill.bills',compact('bills','billJoin','items','agencies','departments','users'));
        }

        public function bills_historyIndex()
        {
            $id = Auth::User()->id;
            Session::put('acc_id', $id);

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
            return view('bill.bills_history',compact('bills','billJoin','items','agencies','departments','users'));
        }
        
        /** page create estimates */
        public function createEstimateIndex()
        {
            
            $id = Auth::User()->id;
            Session::put('acu_id', $id);
            
            $agencies = DB::table('agencies')->get();
            $departments = DB::table('departments')->get();
            $items     = DB::table('items')->get();
            $users     = DB::table('users')->get();
            $bills     = DB::table('bills')->get();
            $billJoin  = DB::table('bills')
                ->join('bill_adds', 'bills.bill_number', '=', 'bill_adds.bill_number')
                ->join('items', 'bill_adds.item_id', '=', 'items.item_id')
                ->join('departments', 'bill_adds.depart_id', '=', 'departments.depart_id')
                ->select('bills.*', 'bill_adds.*','items.*','departments.*')
                ->get();
            return view('bill.createestimate',compact('bills','billJoin','items','agencies','departments','users'));
        }

        public function createEstimateSaveRecord(Request $request)
        {
            // dd($request);
            $request->validate([
                'company'   => 'required',
                'agencies'   => 'required',
                'bill_date'   => 'required',
                'requester'   => 'required',
                'users'   => 'required',
                'item'   => 'required',
                'departments'   => 'required',
                'qty.*'   => 'required',
                'desc.*' => 'required',


            ]);
    
            DB::beginTransaction();
            try {            
                $bills = new Bill;
                $bills->acu_id         = Session::get('acc_id');
                $bills->company        = $request->company;
                $bills->age_id         = $request->agencies;
                $bills->bill_date      = $request->bill_date;
                $bills->requester      = $request->requester;
                $bills->user_id        = $request->users;
                $bills->save();
                // dd($bills);
    
                $bill_number = DB::table('bills')->orderBy('bill_number','DESC')->select('bill_number')->first();
                $bill_number = $bill_number->bill_number;
                
                foreach ($request->item as $key => $items) {
                    $billsAdds = new BillAdd; // Create a new instance of BillAdd model
                    $billsAdds->item_id     = $items;
                    $billsAdds->bill_number = $bill_number;
                    $billsAdds->depart_id   = $request->departments[$key]; // Use 'depart_id' if that's the correct field name
                    $billsAdds->qty         = $request->qty[$key];
                    $billsAdds->desc         = $request->desc[$key];
                    $billsAdds->save();
            }
    
                DB::commit();
                Toastr::success('Create new Bills successfully :)','Success');
                return redirect()->route('form/bill/page');
            } catch(\Exception $e) {
                DB::rollback();
                Toastr::error('Add Bills fail :)'. $e->getMessage(), 'Error');
                return redirect()->back();
            }
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
