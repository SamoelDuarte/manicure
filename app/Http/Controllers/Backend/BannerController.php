<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils;
use App\Http\Requests\Backend\BannerRequest;
use App\Models\Banner;
use App\Services\ImageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $this->authorize('access_banner');

        $banners = Banner::when(\request()->keyword != null, function ($query) {
            $query->search(\request()->keyword);
        })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'id', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);

        return view('backend.banner.index', compact('banners'));
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $this->authorize('create_banner');

        if ($request->validated()) {


            $banner = Banner::create($request->except('tags', 'images', '_token'));


            if ($request->images) {
                $imageBanner = Utils::createRecruitmentCode();
               

                $banner->image =  (new ImageService())->storeBannerImages($imageBanner, $request->images);

                $banner->update();
            }

            clear_cache();

            return redirect()->route('admin.banner.index')->with([
                'message' => 'Banner Criado com sucesso.',
                'alert-type' => 'success'
            ]);
        }

        return back()->with([
            'message' => 'Erro interno',
            'alert-type' => 'error'
        ]);
    }

    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $this->authorize('edit_product');

        if ($request->validated()) {

            $banner->update($request->except('tags', 'images', '_token'));

            if ($request->images) {
                $imageBanner = Utils::createRecruitmentCode();

                $banner->image =  (new ImageService())->storeBannerImages($imageBanner, $request->images);

                $banner->update();
                
            }

            clear_cache();
            return redirect()->route('admin.banner.index')->with([
                'message' => 'Banner Atualizado com Sucesso.',
                'alert-type' => 'success'
            ]);
        }

        return back()->with([
            'message' => 'Erro interno',
            'alert-type' => 'error'
        ]);
    }


    public function destroy(Banner $banner): RedirectResponse
    {
        $this->authorize('delete_banner');

      
          
                (new ImageService())->unlinkImage($banner->image, 'banners');
               
          
        

        $banner->delete();

        clear_cache();
        return redirect()->route('admin.banner.index')->with([
            'message' => 'Banner Deletado com Sucesso.',
            'alert-type' => 'success'
        ]);
    }

    public function create()
    {
        return view('backend.banner.create');
    }

    public function edit(Banner $banner): View
    {
        $this->authorize('edit_banner');

        return view('backend.banner.edit', compact('banner'));
    }
    public function removeImage(Request $request): bool
    {
        $this->authorize('delete_banner');
      
       

        (new ImageService())->unlinkImage($request->image, 'banners');


        $banner = Banner::where('id', $request->id)->first();
        $banner->image = "";
        $banner->update();
        clear_cache();

        return true;
    }
}
