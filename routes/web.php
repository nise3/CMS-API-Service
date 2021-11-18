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
    $customRouter()->resourceRoute('banners', 'BannerController')->render();
    $customRouter()->resourceRoute('sliders', 'SliderController')->render();
    $customRouter()->resourceRoute('faqs', 'FaqController')->render();
    $customRouter()->resourceRoute('visitor-feedback-suggestions', 'VisitorFeedbackSuggestionController')->render();
    $customRouter()->resourceRoute('static-page-types', 'StaticPageTypeController')->render();


    /** publish or archive  */
    $router->put('gallery-albums/publish-or-archive/{id}', ["as" => "gallery.albums.publish.archive", "uses" => "GalleryAlbumController@publishOrArchive"]);
    $router->put('gallery-images-videos/publish-or-archive/{id}', ["as" => "gallery.images.videos.publish.archive", "uses" => "GalleryImageVideoController@publishOrArchive"]);
    $router->put('notice-or-news/publish-or-archive/{id}', ["as" => "notice.news.publish.archive", "uses" => "NoticeOrNewsController@publishOrArchive"]);
    $router->put('recent-activities/publish-or-archive/{id}', ["as" => "recent.activities.publish.archive", "uses" => "RecentActivityController@publishOrArchive"]);

    /** Static page & block */
    $router->get('static-page-blocks/{page_code}', ["as" => "static.page.block", "uses" => "StaticPageContentOrPageBlockController@getStaticPageOrBlock"]);
    $router->put('static-page-blocks/{page_code}', ["as" => "static.page.block", "uses" => "StaticPageContentOrPageBlockController@createOrUpdateStaticPageOrBlock"]);

    $router->group(['prefix' => 'public', 'as' => 'public'], function () use ($router) {
        $router->get('faqs/{id}', ["as" => "faqs.read", "uses" => "FaqController@clientSideRead"]);
        $router->get('notice-or-news/{id}', ["as" => "notice.news.read", "uses" => "NoticeOrNewsController@clientSideRead"]);
        $router->get('recent-activities/{id}', ["as" => "recent.activities.read", "uses" => "RecentActivityController@clientSideRead"]);
        $router->get('nise3-partners/{id}', ["as" => "nise3.partners.read", "uses" => "Nise3PartnerController@clientSideRead"]);
        $router->get('gallery-albums/{id}', ["as" => "gallery.albums.read", "uses" => "GalleryAlbumController@clientSideRead"]);
        $router->get('gallery-images-videos/{id}', ["as" => "gallery.images.videos.read", "uses" => "GalleryImageVideoController@clientSideRead"]);

        $router->get('faqs', ["as" => "faqs.list", "uses" => "FaqController@clientSideGetList"]);
        $router->get('notice-or-news', ["as" => "notice.news.list", "uses" => "NoticeOrNewsController@clientSideGetList"]);
        $router->get('recent-activities', ["as" => "recent.activities.list", "uses" => "RecentActivityController@clientSideGetList"]);
        $router->get('nise3-partners', ["as" => "nise3.partners.list", "uses" => "Nise3PartnerController@clientSideGetList"]);
        $router->get('gallery-albums', ["as" => "gallery.albums.list", "uses" => "GalleryAlbumController@clientSideGetList"]);
        $router->get('gallery-images-videos', ["as" => "gallery.images.videos.list", "uses" => "GalleryImageVideoController@clientSideGetList"]);
        $router->get('sliders', ["as" => "sliders.list", "uses" => "SliderController@clientSideGetList"]);

        /** Public Static page & block */
        $router->get('static-page-blocks/{page_code}', ["as" => "static.page.block", "uses" => "StaticPageContentOrPageBlockController@clientSideGetStaticPageOrBlock"]);
    });
    /** calender */
    $customRouter()->resourceRoute('calender-events', 'CalenderEventsController')->render();

//    /** Language Field Remove From CsmLanguage Table */
//    $router->post('delete-other-language',
//        [
//            "as" => "cms.delete-other-language",
//            "uses" => "CmsLanguageController@deleteLanguageFieldByKeyId"
//        ]
//    );


    $router->post('create-event-after-batch-assign', ["as" => "calender-events.bacth-assign-event", "uses" => "CalenderEventsController@createEventAfterBatchAssign"]);


    $router->get('cms-global-config', [
        "as" => "cms.global-config",
        "uses" => "CmsGlobalConfigController@getGlobalConfig"
    ]);

});

