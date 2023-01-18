<?php

namespace Modules\Categories\Services;

use Illuminate\Http\JsonResponse;
use Modules\Categories\Models\Category;

class CategoryService
{
    public $Request;

    /**
     * Get list of categories as tree.
     *
     * @return JsonResponse
     */
    public function getList()
    {
        $Categories = Category::get()->toArray();
        $Categories = $this->buildTree($Categories);

        $Response['Response'] = [
            'Categories' => $Categories
        ];

        return response()->json($Response, 200);
    }

    /**
     * Creates new category in DB.
     *
     * @return JsonResponse
     */
    public function create()
    {
        $Data = $this->Request['data'];

        $Category = Category::createCategory($Data['category_name'], $Data['parent_id']);

        $Response['Response'] = [
            'Category' => $Category
        ];

        return response()->json($Response, 200);
    }

    /**
     * Gets single record from DB by Id.
     *
     * @return JsonResponse
     */
    public function show($Id)
    {
        $Category = Category::findorfail($Id);

        $Response['Response'] = [
            'Category' => $Category
        ];

        return response()->json($Response, 200);
    }

    /**
     * Deletes category from DB by Id.
     *
     * @return JsonResponse
     */
    public function delete($Id)
    {
        $Category = Category::findorfail($Id);
        if(Category::isHaveChildren($Category->id)){
            abort(403, 'Category has children categories.');
        }
        $Category->delete();

        $Response['Response'] = [
            'Message' => 'Category was successfully deleted.'
        ];

        return response()->json($Response, 200);
    }

    /**
     * Builds tree from Categories array.
     *
     * @param $Elements
     * @param $ParentId
     * @return array
     */
    public function buildTree($Elements, $ParentId = 0)
    {
        $Tree = array();

        foreach ($Elements as $Element) {
            if ($Element['parent_id'] == $ParentId) {
                $Children = $this->buildTree($Elements, $Element['id']);
                if ($Children) {
                    $Element['children'] = $Children;
                }
                $Tree[] = $Element;
            }
        }
        return $Tree;
    }

    /**
     * Setter for $request variable.
     *
     * @param $Request
     * @return CategoryService
     */
    public function setRequest($Request)
    {
        $this->Request = $Request;
        return $this;
    }
}
