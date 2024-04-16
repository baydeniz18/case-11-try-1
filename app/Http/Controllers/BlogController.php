<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class BlogController extends Controller
{

    public function index(Request $request)
    {
        // return Blog::all();

        // Kategori filtresi ve silinen kayıtlar gelmeyecek

        $category_id = $request->query('category_id');

        if($category_id){
            $blogs = Blog::where('category_id', $category_id) 
            ->whereNull('deleted_at')
            ->get();
        } else {
            $blogs = Blog::whereNull('deleted_at')
            ->get();
        }



        return $blogs;
    }

    
    public function store(StoreBlogRequest $request)
    {

        $id = auth()->user()->id;

        $data = $request->validated();
        $data['user_id'] = $id;
        $data['deleted_at'] = null;

        Blog::create($data);

        return response()->json([
            'S'=>'T',
            'message' => 'Yeni blog kaydı oluşturuldu.'
        ]);
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        
        if($blog){
            return $blog;
        } else {
            return response()->json(['message' => 'Blog bulunamadı']);
           
        }
    }


    public function update(UpdateBlogRequest $request, $id)
    {

        $data = $request->validated();
        $blog = Blog::findOrFail($id);


        if ($blog) {

            $user_id = auth()->user()->id;

            if($user_id == $blog['user_id']){
                $blog->update([
                    'category_id' => $data['category_id'],
                    'header' => $data['header'],
                    'desc_short' => $data['desc_short'],
                    'desc_long' => $data['desc_long']
                ]);
    
                return response()->json([
                    'S'=>'T',
                    'message' => 'Blog kaydı düzenlendi.'
                ]);
            } else {
                return response()->json(['message' => 'Sadece size ait blogları düzenleyip silebilirsiniz']);
            }

           
        } else {
            return response()->json(['message' => 'Blog güncellenirken bir hata oluştu']);
        }

    }


    public function destroy($id)
    {
        //kaydı delete atmak isteseydik ;


        //  if ($blog->delete()) {
        //     return response()->json(['message' => 'Blog başarıyla silindi']);
        //  } else {
        //     return response()->json(['message' => 'Blog silinirken bir hata oluştu']);
        //  }

         // yedek yok o yüzden veriyi tutuyorum 

         // list işlemlerinde gözükmeyecek


         $blog = Blog::findOrFail($id);
 
         if ($blog) {
 
             $user_id = auth()->user()->id;

             $now = Carbon::now();
 
             if($user_id == $blog['user_id']){
                 $blog->update([
                    'deleted_at'=> $now
                 ]);
     
                 return response()->json([
                     'S'=>'T',
                     'message' => 'Blog kaydı silindi.'
                 ]);
             } else {
                 return response()->json(['message' => 'Sadece size ait blogları düzenleyip silebilirsiniz']);
             }
 
            
         } else {
             return response()->json(['message' => 'Blog silinirken bir hata oluştu']);
         }


    }
}
