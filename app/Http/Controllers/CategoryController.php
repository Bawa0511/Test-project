<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Validator;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
    public function addcategory()
    {
        $category = Category::all();
        return view('category.add')->with('category', $category);
    }

    public function insertcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }
        
        $category = new Category();
        $category->name = $request->name;
        if($request->status == '1')
        {
            $category->status = '1';
        }
        $category->save();

        return back();
    }

    public function editcategory(Request $request, $id)
    {
        $category = Category::where('id',$id)->first();
        return view("category.edit")->with('category', $category);
    }

    public function updatecategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }

        $category = Category::where('id',$request->id)->first();
        $category->name = $request->name;
        if($request->status)
        {
            $category->status = '1';
        } else {
            $category->status = '0';
        }
        $category->update();

        return redirect()->route('add.category');
    }

    public function deletecategory(Request $request)
    {
        $category = SubCategory::where('category_id',$request->id)->first();
        if($category)
        {
            return response()->json([
                'status' => 420,
                'message' => 'First delete subcategories of which is under this category.'
            ]);
        } else {
            $category = Category::where('id',$request->id)->delete();
            $category_all = Category::all();
            $html = "";
            foreach($category_all as $key => $value)
            {
                $id = $key + 1;
                $url = "{{ route('edit.category', ['id'=>".$value->id."]) }}";
                $img_url= 'images/icon-bin.jpg';
                // print_r($img_url); die;
                $html .= '<tr id="{{$value->id}}">
                    <td align="left" valign="top">'.$id.'</td>
                    <td align="left" valign="top">'.$value->name.'</td>
                    <td align="left" valign="top"><strong>';
                    if($value->status == "1"){ 
                        $html .=  "Active"; 
                    } else { 
                        $html .= "Disable"; 
                    }
                    $html .= '</strong></td>
                    <td align="left" valign="top"><a href="'.$url.'">Edit</a></td>
                    <td align="center" valign="top"><button class="delete btn" data-id="'.$value->id.'"><img src="'.$img_url.'" alt="" width="25" height="25" border="0" align="absmiddle" /></button></td>
                </tr>';
            }

            return response()->json([
                'status' => 401,
                'html' => $html,
                'message' => 'Category deleted successfully'
            ]);
        }
    }

    public function addsubcategory(Request $request)
    {
        $category = Category::where('status','1')->get();
        $sub_category = SubCategory::all();
        return view('sub_category.add')->with('category', $category)->with('sub_category', $sub_category);
    }

    public function insertsubcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }

        $category = new SubCategory();
        $category->category_id = $request->category;
        $category->name = $request->name;
        if($request->status == '1')
        {
            $category->status = '1';
        }
        $category->save();

        return back();
    }
    
    public function editsubcategory(Request $request, $id)
    {
        $sub_category = SubCategory::where('id',$id)->first();
        $category = Category::all();
        return view("sub_category.edit")->with('category', $category)->with('sub_category', $sub_category);
    }

    public function updatesubcategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }

        $category = SubCategory::where('id',$request->id)->first();
        $category->category_id = $request->category;
        $category->name = $request->name;
        if($request->status)
        {
            $category->status = '1';
        } else {
            $category->status = '0';
        }
        $category->save();

        return redirect()->route('add.sub_category');
    }

    public function deletesubcategory(Request $request)
    {
        $category = SubCategory::where('id',$request->id)->delete();
        $category_all = SubCategory::all();
        $html = "";
        foreach($category_all as $key => $value)
        {
            $name = Category::where('id', $value->category_id)->first();
            $id = $key + 1;
            $url = "{{ route('edit.sub_category', ['id'=>".$value->id."]) }}";
            $img_url= 'images/icon-bin.jpg';
            // print_r($img_url); die;
            $html .= '<tr id="{{$value->id}}">
                <td align="left" valign="top">'.$id.'</td>
                <td align="left" valign="top">'.$name->name.'</td>
                <td align="left" valign="top">'.$value->name.'</td>
                <td align="left" valign="top"><strong>';
                if($value->status == "1"){ 
                    $html .=  "Active"; 
                } else { 
                    $html .= "Disable"; 
                }
                $html .= '</strong></td>
                <td align="left" valign="top"><a href="'.$url.'">Edit</a></td>
                <td align="center" valign="top"><button class="delete btn" data-id="'.$value->id.'"><img src="'.$img_url.'" alt="" width="25" height="25" border="0" align="absmiddle" /></button></td>
            </tr>';
        }
        return response()->json([
            'status' => 401,
            'html' => $html,
            'message' => 'Sub category deleted successfully'
        ]);
    }

    

}
