<?php namespace Concreta\ShortURL\Controllers;

use Backend;
use Redirect;
use BackendMenu;
use Backend\Classes\Controller;
use Concreta\ShortURL\Classes\Resolver;
use Concreta\ShortURL\Models\ShortURL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShortURLController extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Concreta.ShortURL', 'shorturl-mainmenu', 'shorturl-sidemenu-shorturls');
    }

    public function create()
    {
        $redirect = Backend::url('concreta/shorturl/shorturlcontroller/');
        return Redirect::to($redirect);
    }

    /**
     * Redirect the user to the intended destination URL. If the default
     * route has been disabled in the config but the controller has
     * been reached using that route, return HTTP 404.
     *
     * @param  Request  $request
     * @param  Resolver  $resolver
     * @param  string  $shortURLKey
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Resolver $resolver, string $shortURLKey): RedirectResponse
    {
        $shortURL = ShortURL::where('url_key', $shortURLKey)->firstOrFail();

        $resolver->handleVisit(request(), $shortURL);

        if ($shortURL->forward_query_params) {
            return redirect($this->forwardQueryParams($request, $shortURL), $shortURL->redirect_status_code);
        }

        return redirect($shortURL->destination_url, $shortURL->redirect_status_code);
    }

    /**
     * Add the query parameters from the request to the end of the
     * destination URL that the user is to be forwarded to.
     *
     * @param  Request  $request
     * @param  ShortURL  $shortURL
     * @return string
     */
    private function forwardQueryParams(Request $request, ShortURL $shortURL): string
    {
        $queryString = parse_url($shortURL->destination_url, PHP_URL_QUERY);

        if (empty($request->query())) {
            return $shortURL->destination_url;
        }

        $separator = $queryString ? '&' : '?';

        return $shortURL->destination_url.$separator.http_build_query($request->query());
    }
}
