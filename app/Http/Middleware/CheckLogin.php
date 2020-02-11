<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        
        $member = $request->session()->get('memeber', '');
        // if($member == '') {
        if($member != '') {
          // $return_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
          $return_url = $_SERVER['HTTP_REFERER'];
          return redirect('http://localhost/book/public/login?return_url=' . urlencode($return_url));
        }
        
        return $next($request);
    }

}
