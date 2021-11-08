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


    $router->group(['prefix' => 'public', 'as' => 'public'], function () use ($router) {
        $router->get('faqs/{id}', ["as" => "faqs", "uses" => "FaqController@clientSideRead"]);
        $router->get('static-pages/{id}', ["as" => "static.pages", "uses" => "StaticPageController@clientSideRead"]);
        $router->get('notice-or-news/{id}', ["as" => "notice.news", "uses" => "NoticeOrNewsController@clientSideRead"]);
        $router->get('recent-activities/{id}', ["as" => "recent.activities", "uses" => "RecentActivityController@clientSideRead"]);
        $router->get('nise3-partners/{id}', ["as" => "recent.activities", "uses" => "Nise3PartnerController@clientSideRead"]);
        $router->get('gallery-albums/{id}', ["as" => "gallery.albums.activities", "uses" => "GalleryAlbumController@clientSideRead"]);
        $router->get('gallery-images-videos/{id}', ["as" => "gallery.images.videos.activities", "uses" => "GalleryImageVideoController@clientSideRead"]);
        $router->get('sliders/{id}', ["as" => "public.sliders", "uses" => "SliderController@clientSideRead"]);
    });
    /** calender */
    $customRouter()->resourceRoute('calender-events', 'CalenderEventsController')->render();

    /** Language Field Remove From CsmLanguage Table */
    $router->post('delete-other-language',
        [
            "as" => "cms.delete-other-language",
            "uses" => "CmsLanguageController@deleteLanguageFieldByKeyId"
        ]
    );

    $router->get('cms-global-config', [
        "as" => "cms.global-config",
        "uses" => "CmsGlobalConfigController@getGlobalConfig"
    ]);

});

