<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\CategorySubmitRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends ApiController
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * CategoryController constructor.
     * - - -
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(
            $this->categoryRepository->getPaginated($request->limit)
        );
    }

    /**
     * @param $id
     * @return CategoryResource
     */
    public function show($id)
    {
        return new CategoryResource(
            $this->categoryRepository->findOrFail($id)
        );
    }

    /**
     * @param CategorySubmitRequest $request
     * @return CategoryResource
     */
    public function store(CategorySubmitRequest $request)
    {
        $category = $this->categoryRepository->create(
            $request->name,
            $request->slug,
            Auth::id()
        );

        return new CategoryResource($category);
    }

    /**
     * @param CategorySubmitRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategorySubmitRequest $request, $id)
    {
        $this->categoryRepository->findOrFail($id);

        $this->categoryRepository->update(
            $id,
            $request->name,
            $request->slug,
            Auth::id()
        );

        return $this->success('The category updated successfully.');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findOrFail($id);
        $category->delete();

        return $this->success('The category deleted successfully.', Response::HTTP_NO_CONTENT);
    }
}
