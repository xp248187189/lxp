<?php

namespace App\Jobs;

use App\Model\Article;
use App\Model\ArticleComment;
use App\Model\UserComment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CountArticleComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //本来是修改评论数现在是修改评论数或者修改回复数
    protected $articleIdOrUserCommentId;//文章id或者留言id
    protected $type;//类别 1是文章id，2是留言id

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($articleIdOrUserCommentId,$type)
    {
        $this->articleIdOrUserCommentId = $articleIdOrUserCommentId;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 1){
            $count = ArticleComment::where('article_id','=',$this->articleIdOrUserCommentId)->count();
            $articleOrm = Article::find($this->articleIdOrUserCommentId);
            if ($articleOrm){
                $articleOrm->commentCount = $count;
                $articleOrm->save();
            }
        }else{
            $count = UserComment::where('pid','=',$this->articleIdOrUserCommentId)->count();
            $userCommentOrm = UserComment::find($this->articleIdOrUserCommentId);
            if ($userCommentOrm){
                $userCommentOrm->huifuCount = $count;
                $userCommentOrm->save();
            }
        }
    }
}
