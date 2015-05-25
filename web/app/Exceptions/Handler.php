<?php namespace Feeder\Exceptions;

use Exception;
use Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Feeder\Api\Responses\ResponseError;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{

		if ($this->isHttpException($e)) 
		{

			if ($e instanceof MethodNotAllowedHttpException) 
			{
				$response = new ResponseError('error', [sprintf('Method %s is not allowed for route %s', $request->method(), $request->url())]);
				return Response::json($response->toArray(), 405);
			}
		}
		return parent::render($request, $e);
	}

}
