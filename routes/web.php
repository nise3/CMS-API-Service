<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Helpers\Classes\CustomRouter;
use App\Services\Common\LanguageCodeService;

$customRouter = function (string $as = '') use ($router) {
    $custom = new CustomRouter($router);
    return $custom->as($as);
};

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1', 'as' => 'api.v1'], function () use ($router, $customRouter) {
    $router->get('/', ['uses' => 'ApiInfoController@apiInfo']);

    $customRouter()->resourceRoute('divisions', 'LocDivisionController')->render();
    $customRouter()->resourceRoute('districts', 'LocDistrictController')->render();
    $customRouter()->resourceRoute('upazilas', 'LocUpazilaController')->render();

    $router->get('countries', ['as' => 'countries.get-list', 'uses' => 'CountryController@getList']);

    $customRouter()->resourceRoute('nise3-partners', 'Nise3PartnerController')->render();
    $customRouter()->resourceRoute('notice-or-news', 'NoticeOrNewsController')->render();
    $customRouter()->resourceRoute('recent-activities', 'RecentActivityController')->render();

    $customRouter()->resourceRoute('gallery-albums', 'GalleryAlbumController')->render();
    $customRouter()->resourceRoute('gallery-images-videos', 'GalleryImageVideoController')->render();
    $customRouter()->resourceRoute('video-categories', 'VideoCategoryController')->render();
    $customRouter()->resourceRoute('videos', 'VideoController')->render();
    $customRouter()->resourceRoute('sliders', 'SliderController')->render();
    $customRouter()->resourceRoute('static-pages', 'StaticPageController')->render();
    $customRouter()->resourceRoute('faqs', 'FaqController')->render();
    $customRouter()->resourceRoute('visitor-feedback-suggestions', 'VisitorFeedbackSuggestionController')->render();

    /** Client Site Read Detail */
    $router->get('faqs/{id}/client-site-read',[
        "as"=>"client.client-site-read",
        "uses"=>"FaqController@clientSiteRead"
    ]);

    $router->group(['prefix' => 'public', 'as' => 'public'], function () use ($router) {
        $router->get('faqs/{id}', ["as" => "public.faqs", "uses" => "FaqController@clientSiteRead"]);
        $router->get('static-pages/{id}', ["as" => "public.static.pages", "uses" => "StaticPageController@clientSiteRead"]);
        $router->get('notice-or-news/{id}', ["as" => "public.notice.news", "uses" => "NoticeOrNewsController@clientSiteRead"]);
        $router->get('recent-activities/{id}', ["as" => "public.recent.activities", "uses" => "RecentActivityController@clientSiteRead"]);
        $router->get('nise3-partners/{id}', ["as" => "public.recent.activities", "uses" => "Nise3PartnerController@clientSiteRead"]);
        $router->get('gallery-albums/{id}', ["as" => "public.gallery.albums.activities", "uses" => "GalleryAlbumController@clientSiteRead"]);
        $router->get('gallery-images-videos/{id}', ["as" => "public.gallery.images.videos.activities", "uses" => "GalleryImageVideoController@clientSiteRead"]);
        $router->get('sliders/{id}', ["as" => "public.sliders", "uses" => "SliderController@clientSiteRead"]);
    });

    /** Language Field Remove From CsmLanguage Table */
    $router->post('delete-other-language',
        [
            "as" => "cms.delete-other-language",
            "uses" => "CmsLanguageController@deleteLanguageFieldByKeyId"
        ]
    );

    $router->get('cms-global-config',[
        "as"=>"cms.global-config",
        "uses"=>"CmsGlobalConfigController@getGlobalConfig"
    ]);

});

