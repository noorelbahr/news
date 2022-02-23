<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\NewsCommentRequest;
use App\Http\Resources\Api\V1\CommentResource;
use App\Repositories\Interfaces\NewsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NewsCommentController extends ApiController
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
     * @param $id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request, $id)
    {
        $news = $this->newsRepository->findOrFail($id);

        return CommentResource::collection(
            $news->comments()->latest()->simplePaginate($request->limit)
        );
    }

    /**
     * @param NewsCommentRequest $request
     * @param $id
     * @return CommentResource
     */
    public function store(NewsCommentRequest $request, $id)
    {
        $news = $this->newsRepository->findOrFail($id);

        $comment = $news->comments()->create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'created_by' => Auth::id()
        ]);

        return new CommentResource($comment);
    }

    /**
     * @param $newsId
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($newsId, $id)
    {
        $news = $this->newsRepository->findOrFail($newsId);
        $comment = $news->comments()->findOrFail($id);
        if ($comment->user_id !== Auth::id()) {
            return $this->fail('You\'re not the author!');
        }

        $comment->delete();

        return $this->success('The comment deleted successfully.', Response::HTTP_NO_CONTENT);
    }
}
