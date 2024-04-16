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

        /**
 * @OA\Schema(
 *     schema="Blog",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="Blog ID"
 *     ),
 *     @OA\Property(
 *         property="category_id",
 *         type="integer",
 *         description="Category ID of the blog"
 *     ),
 *     @OA\Property(
 *         property="header",
 *         type="string",
 *         description="Header of the blog"
 *     ),
 *     @OA\Property(
 *         property="desc_short",
 *         type="string",
 *         description="Short description of the blog"
 *     ),
 *     @OA\Property(
 *         property="desc_long",
 *         type="string",
 *         description="Long description of the blog"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the blog was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Date and time when the blog was last updated"
 *     ),
 *     @OA\Property(
 *         property="deleted_at",
 *         type="string",
 *         format="date-time",
 *         nullable=true,
 *         description="Date and time when the blog was soft deleted"
 *     )
 * )
 *

     * @OA\Get(
     *     path="/api/blog_list",
     *     summary="Get all blogs",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Filter blogs by category ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of blogs",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Blog"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No blogs found"
     *     )
     * )
     */


    public function index(Request $request)
    {
        // return Blog::all();

        // Kategori filtresi ve silinen kayıtlar gelmeyecek

        $category_id = $request->query('category_id');

        if($category_id){
            $blogs = Blog::where('category_id', $category_id)
            ->whereNull('deleted_at')
            ->join('categories', 'blogs.category_id', '=', 'categories.id')
            ->select('blogs.*', 'categories.category_name')
            ->get();
        } else {
            $blogs = Blog::whereNull('deleted_at')
            ->get();
        }



        return $blogs;
    }

    /**
 * @OA\Post(
 *     path="/api/add_blog",
 *     summary="Add a new blog",
 *     tags={"Blogs"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="Blog data",
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="category_id",
 *                     type="integer",
 *                     description="Category ID",
 *                     example="2"
 *                 ),
 *                 @OA\Property(
 *                     property="header",
 *                     type="string",
 *                     description="Blog header",
 *                     example="güncelleme2"
 *                 ),
 *                 @OA\Property(
 *                     property="desc_short",
 *                     type="string",
 *                     description="Short description",
 *                     example="güncelleme2"
 *                 ),
 *                 @OA\Property(
 *                     property="desc_long",
 *                     type="string",
 *                     description="Long description",
 *                     example="güncelleme2"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Blog added successfully"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized"
 *     )
 * )
 */


    
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
