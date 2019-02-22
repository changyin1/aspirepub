<?php

namespace Aspire\QuestionUpload\Http\Middleware;

use Aspire\QuestionUpload\QuestionUpload;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(QuestionUpload::class)->authorize($request) ? $next($request) : abort(403);
    }
}
