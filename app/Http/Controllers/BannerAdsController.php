<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BannerAd;
use Illuminate\Http\Request;
use Exception;

class BannerAdsController extends Controller
{

    /**
     * Display a listing of the banner ads.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $bannerAds = BannerAd::paginate(25);

        return view('banner_ads.index', compact('bannerAds'));
    }

    /**
     * Show the form for creating a new banner ad.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {


        return view('banner_ads.create');
    }

    /**
     * Store a new banner ad in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {


            $data = $this->getData($request);

            BannerAd::create($data);

            return redirect()->route('banner_ads.banner_ad.index')
                ->with('success_message', 'Banner Ad was successfully added.');

    }

    /**
     * Display the specified banner ad.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $bannerAd = BannerAd::findOrFail($id);

        return view('banner_ads.show', compact('bannerAd'));
    }

    /**
     * Show the form for editing the specified banner ad.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $bannerAd = BannerAd::findOrFail($id);


        return view('banner_ads.edit', compact('bannerAd'));
    }


    public function update($id, Request $request)
    {


            $data = $this->getData($request);

            $bannerAd = BannerAd::findOrFail($id);
            $bannerAd->update($data);

            return redirect()->route('banner_ads.banner_ad.index')
                ->with('success_message', 'Banner Ad was successfully updated.');

    }


    public function destroy($id)
    {
            // dd($id);

            $bannerAd = BannerAd::findOrFail($id);
            $bannerAd->delete();

            return redirect()->route('banner_ads.banner_ad.index')->with('success_message', 'Banner Ad was successfully deleted.');

    }


    protected function getData(Request $request)
    {
        $rules = [
                'title' => 'required',
            'photo' => ['required','file','nullable'],
            'link' => 'required',
            'banner_type' => 'required',
        ];

        $data = $request->validate($rules);
        if ($request->has('custom_delete_photo')) {
            $data['photo'] = null;
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->moveFile($request->file('photo'));
        }

        return $data;
    }

    /**
     * Moves the attached file to the server.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return string
     */
    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }


        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }
}
