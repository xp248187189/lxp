<?php

namespace App\Jobs;

use App\Model\Article;
use App\Model\ArticleComment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CountArticleComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $articleId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $count = ArticleComment::where('article_id','=',$this->articleId)->count();
        $articleOrm = Article::find($this->articleId);
        if ($articleOrm){
            $articleOrm->commentCount = $count;
            $articleOrm->save();
        }
    }
}
