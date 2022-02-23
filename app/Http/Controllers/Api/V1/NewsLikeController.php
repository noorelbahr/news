<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\LikeResource;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NewsLikeController extends ApiController
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
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id)
    {
        $news = $this->newsRepository->findOrFail($id);

        return LikeResource::collection(
            $news->likes()->latest()->get()
        );
    }

    /**
     * @param $id
     * @return LikeResource
     */
    public function like($id)
    {
        $news = $this->newsRepository->findOrFail($id);

        $like = $news->likes()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['created_by' => Auth::id()]
        );

        return new LikeResource($like);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unlike($id)
    {
        $news = $this->newsRepository->findOrFail($id);

        $news->likes()->where('user_id', Auth::id())->delete();

        return $this->success('Unliked.', Response::HTTP_NO_CONTENT);
    }
}
