<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\NewsSubmitRequest;
use App\Http\Resources\Api\V1\NewsResource;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends ApiController
{
    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;

    /**
     * NewsController constructor.
     * - - -
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return NewsResource::collection(
            $this->newsRepository->getPaginated($request->limit)
        );
    }

    /**
     * @param $id
     * @return NewsResource
     */
    public function show($id)
    {
        return new NewsResource(
            $this->newsRepository->findOrFail($id)
        );
    }

    /**
     * @param NewsSubmitRequest $request
     * @return NewsResource|\Illuminate\Http\JsonResponse
     */
    public function store(NewsSubmitRequest $request)
    {
        DB::beginTransaction();
        try {
            $news = $this->newsRepository->create(
                Auth::id(),
                $request->category_id,
                $request->title,
                $request->body,
                $request->tags,
                Auth::id()
            );

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('/images/news');

                $news->images()->create(['filename' => $path, 'created_by' => Auth::id()]);
            }

            DB::commit();

            return new NewsResource($news);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail($e->getMessage());
        }
    }

    /**
     * @param NewsSubmitRequest $request
     * @param $id
     * @return NewsResource|\Illuminate\Http\JsonResponse
     */
    public function update(NewsSubmitRequest $request, $id)
    {
        DB::beginTransaction();
        $news = $this->newsRepository->findOrFail($id);

        try {
            if ($news->user_id !== Auth::id()) {
                throw new \Exception('You\'re not the author!');
            }

            $this->newsRepository->update(
                $id,
                $request->category_id,
                $request->title,
                $request->body,
                $request->tags,
                Auth::id()
            );

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('/images/news');

                $news->images()->create(['filename' => $path, 'created_by' => Auth::id()]);
            }

            DB::commit();

            return $this->success('The news updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fail($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $news = $this->newsRepository->findOrFail($id);
        if ($news->user_id !== Auth::id()) {
            return $this->fail('You\'re not the author!');
        }

        $news->delete();

        return $this->success('The news deleted successfully.', Response::HTTP_NO_CONTENT);
    }
}
