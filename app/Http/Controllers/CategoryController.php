<?php

namespace App\Http\Controllers;

use App\Models\Category;

/**
 * @OA\Tag(
 *     name="Categories",
 *     description="Endpoints for managing categories"
 * )
 */

 /**
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="Bearer Token"
 * )
 */

/**
 * @OA\Get(
 *     path="/api/category_list",
 *     summary="Get all categories",
 *     security={{"bearerAuth": {}}},
 *     tags={"Categories"},
 *     @OA\Response(
 *         response=200,
 *         description="List of categories",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="category_name", type="string", example="Category 1")
 *             )
 *         )
 *     )
 * )
 */

class CategoryController extends Controller
{
    
    public function index()
    {
        return Category::select('id','category_name')->get();
    }
}
