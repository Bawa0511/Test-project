<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductPdf;
use Validator;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Hash;
use File;

class ProductController extends Controller
{
    public function addproduct()
    {
        $category = Category::where('status','1')->get();
        $product = Product::all();
        return view('product.add', compact('category','product'));
    }
    
    public function getsubcategory(Request $request)
    {
        // print_r($request->all()); die;
        $id = $request->post('cid');
        $category = SubCategory::where('category_id', $id)->where('status','1')->get();
        $html = '';
        foreach ($category as $list) {
            $html .= '<option value="'.$list->id.'">'.$list->name.'</option>';
        }
        echo $html;
    }
    
    public function insertproduct(Request $request)
    {
        // print_r($request->all()); die;
        $validator = Validator::make($request->all(), [
            'image' => 'required|dimensions:min_width=560,min_height=390',
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }

        $product = new Product();
        $product->cat_id = $request->category;
        if($request->subcategory){
            $sub_id = implode(', ',$request->subcategory);
            $product->sub_cat_id = $sub_id;
        }
        $product->product_name = $request->name;
        // $product->product_image = $request->image;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('product_image/', $filename);
            $product->product_image = $filename;
        }
        $product->short_description = $request->short_description;
        $product->content = $request->content;
        if($request->status){
            $product->status = '1';
        } else {
            $product->status = '0';
        }
        $product->save();
        $product_id = $product->id;

        if($request->title)
        {
            foreach ($request->title as $key => $value) {
            
                $product_des = new ProductDescription();
                $product_des->title = $request->title[$key];
                $product_des->heading = $request->heading[$key];
                $product_des->description = $request->description[$key];
                $product_des->product_id = $product_id;
                $product_des->save();
            }
        }

        if(empty($request->pdf_file))
        {
            foreach ($request->pdf_file as $key => $value) {
                $product_pdf = new ProductPdf();
                $product_pdf->heading = $request->pdf_heading[$key];
                $product_pdf->product_id = $product_id;
                $product_pdf->file = "";
                $product_pdf->save();
            }
        }else
        {
            foreach ($request->pdf_file as $key => $value) {
                $product_pdf = new ProductPdf();
                $product_pdf->heading = $request->pdf_heading[$key];
                $product_pdf->product_id = $product_id;
                if($request->hasfile('pdf_file'))
                {
                    // $file = $request->file('pdf_file');
                    $extenstion = $value->getClientOriginalExtension();
                    $filename = time().'_'.$key.'.'.$extenstion;
                    $value->move('product_pdf/', $filename);
                    $product_pdf->file = $filename;
                }
                $product_pdf->save();
            }
        }
        return back();
    }

    public function editproduct(Request $request, $id)
    {
        $product = Product::where('id',$id)->first();
        $category = Category::where('status','1')->get();
        $product_des = ProductDescription::where('product_id',$request->id)->get();
        $product_pdf = ProductPdf::where('product_id',$request->id)->get();
        return view('product.edit', compact('category','product','product_des','product_pdf'));
    }
    
    public function updateproduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->with('error',$validator->errors());
        }

        $product = Product::where('id',$request->id)->first();
        $product->cat_id = $request->category;
        if($request->subcategory){
            $sub_id = implode(', ',$request->subcategory);
            $product->sub_cat_id = $sub_id;
        }
        $product->product_name = $request->name;
        // $product->product_image = $request->image;
        if($request->edit_image){

            $validator = Validator::make($request->all(), [
                'edit_image' => 'required|dimensions:min_width=560,min_height=390',
            ]);

            if ($validator->fails()) {
                return back()->with('error',$validator->errors());
            }
            
            if($request->hasfile('edit_image'))
            {
                $file = $request->file('edit_image');
                $extenstion = $file->getClientOriginalExtension();
                $filename = time().'.'.$extenstion;
                $file->move('product_image/', $filename);
                $product->product_image = $filename;
            }
            $file = "product_image/".$request->image;
            if(File::exists($file))
            {
                File::delete($file);
            }
        }
        $product->short_description = $request->short_description;
        $product->content = $request->content;
        if($request->status){
            $product->status = '1';
        } else {
            $product->status = '0';
        }
        $product->save();
        $product_id = $product->id;

        if($request->title)
        {
            $productdes = ProductDescription::where('product_id',$request->id)->delete();
            foreach ($request->title as $key => $value) {
            
                $product_des = new ProductDescription();
                $product_des->title = $request->title[$key];
                $product_des->heading = $request->heading[$key];
                $product_des->description = $request->description[$key];
                $product_des->product_id = $product_id;
                $product_des->save();
            }
        }

        if($request->pdf_heading)
        {
            $productpdf = ProductPdf::where('product_id',$request->id)->delete();
            if($request->pdf_file_new){
                foreach ($request->pdf_file_new as $key => $value) {
                    $product_pdf = new ProductPdf();
                    $product_pdf->heading = $request->pdf_heading[$key];
                    $product_pdf->product_id = $product_id;
                    if($request->hasfile('pdf_file_new'))
                    {
                        // $file = $request->file('pdf_file');
                        $extenstion = $value->getClientOriginalExtension();
                        $filename = time().'_'.$key.'.'.$extenstion;
                        $value->move('product_pdf/', $filename);
                        $product_pdf->file = $filename;
                    }
                    $file = "product_pdf/".$request->pdf_file[$key];
                    if(File::exists($file))
                    {
                        File::delete($file);
                    }
                    $product_pdf->save();
                }
            } else {
                foreach ($request->pdf_heading as $key => $value) 
                {
                    $product_pdf = new ProductPdf();
                    $product_pdf->heading = $request->pdf_heading[$key];
                    $product_pdf->product_id = $product_id;
                    if(!empty($request->pdf_file[$key])){
                        $product_pdf->file = $request->pdf_file[$key];
                    }
                    $product_pdf->save();
                }
            }
        }
        
        return redirect()->route('add.product');
    }

    public function deleteproduct(Request $request)
    {
        $product= Product::where('id',$request->id)->first();
        if($product)
        {
            if(!empty($product->product_image))
            {
                $file = "product_image/".$product->product_image;
                if(File::exists($file))
                {
                    File::delete($file);
                }
            }
            $product->delete();
        }
        $productpdf = ProductPdf::where('product_id',$request->id)->get();
        if($productpdf)
        {
            foreach($productpdf as $key => $value)
            {
                if($value->file) {
                    $file = "product_pdf/".$value->file;
                    if(File::exists($file))
                    {
                        File::delete($file);
                    }
                }
                $product_set = ProductPdf::where('id',$value->id)->delete();
            }
        }
        $productdes = ProductDescription::where('product_id',$request->id)->delete();

        $product_all = Product::all();
        $html = "";
            $x = 1;
            foreach($product_all as $key => $value)
            {
                if($value->cat_id){
                    $name = Category::where('id', $value->cat_id)->first();
                    if($name){
                        $name_cat = $name->name;
                    } else {
                        $name_cat = "-";
                    }
                } else {
                    $name_cat = "-";
                }
                $html .='
                <tr id="'.$value->id.'">
                    <td align="left" valign="top">'.$x.'</td>
                    <td align="left" valign="top">'.$name_cat.'</td>
                    <td align="left" valign="top">';
                    if($value->sub_cat_id){
                        $sub_id = explode(", ",$value->sub_cat_id);
                        $sub_cat = SubCategory::whereIn('id', $sub_id)->get();
                        $sub_name = "";
                        foreach($sub_cat as $sub_key => $sub_value)
                        {
                            $sub_name .= $sub_value->name.", ";
                        }
                        $html .= rtrim($sub_name, ", ");
                    } else {
                        $html .= "-";
                    }
                    $html .= '</td>
                    <td align="left" valign="top">';
                    if($value->product_name){
                        $html .= $value->product_name;
                    } else { 
                        $html .= "-";
                    }
                    $html .= '</td>
                    <td align="left" valign="top">';
                    if($value->short_description){
                        $html .= $value->short_description;
                    } else { 
                        $html .= "-";
                    }
                    $html .= '</td>
                    <td align="left" valign="top">';
                    $desc = ProductDescription::where('product_id', $value->id)->get();
                    foreach($desc as $key_desc => $value_desc)
                    {
                        if($value_desc->title || $value_desc->heading || $value_desc->description){
                            $no = $key_desc +1;
                            $html .= "Description no. ".$no."<br><ul>
                            <li>Title:- ".$value_desc->title."</li>
                            <li>Heading:- ".$value_desc->heading."</li>
                            <li>Description:- ".$value_desc->description."</li>
                            </ul><br>";
                        }
                    }
                    $html .= '</td>
                    <td align="left" valign="top"><strong>';
                    if ($value->status == "1"){
                        $html .= "Active";
                    } else {
                        $html .="Disable";
                    }
                    $url = route('edit.product', ['id'=>$value->id]);
                    $html .= '</strong></td>
                    <td align="left" valign="top"><a href="'.$url.'">Edit</a></td>
                    <td align="center" valign="top"><button class="delete btn" data-id="'.$value->id.'"><img src="images/icon-bin.jpg" alt="" width="25" height="25" border="0" align="absmiddle" /></button></td>
                </tr>';
                $x++;
            }
        return response()->json([
            'html' => $html,
            'status' => 401,
            'message' => 'Product deleted successfully'
        ]);
    }

}