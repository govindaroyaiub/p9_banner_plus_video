<div class="sidebar md:w-1/6 mx-4 bg-gray-200 rounded-lg md:flex flex-col justify-between">
    <ul class="space-y-2">
        <li class="{{ request()->is('/') || request()->is('user/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/">Dashboard</a>
        </li>
        <li class="{{ request()->is('banner-showcase') || request()->is('project/banner-showcase/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/banner-showcase">Banner Showcase</a>
        </li>
        <li class="{{ request()->is('video') || request()->is('project/video/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/video">Video</a>
        </li>
        <li class="{{ request()->is('gif') || request()->is('project/gif/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/gif">GIF</a>
        </li>
        <li class="{{ request()->is('social') || request()->is('project/social/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/social">Social Image</a>
        </li>

        @if(Auth::user()->company_id == 1)
        <li class="{{ request()->is('logo') || request()->is('logo/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/logo">Logos/Companies</a>
        </li>
        <li class="{{ request()->is('bills') || request()->is('bills/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/bills">Bills (For Limon Bhai)</a>
        </li>
        @endif

        @if(Auth::user()->company_id == 1)
        <li class="{{ request()->is('banner_sizes') || request()->is('banner_sizes/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/banner_sizes">Banner & GIF Sizes</a>
        </li>
        <li class="{{ request()->is('sizes') || request()->is('sizes/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/sizes">Video Sizes</a>
        </li>
        <li class="{{ request()->is('p9_transfer') || request()->is('p9_transfer/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/p9_transfer">Files Transfer</a>
        </li>
        <li class="{{ request()->is('banner') || request()->is('project/banner/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/banner">Banner (Old System)</a>
        </li>
        @endif
    </ul>
    @if(Auth::check())
    <div class="text-center text-sm text-gray-700 mb-2">&copy; {{ Helper::getTitle(Auth::user()->company_id) }} - <?= Date('Y') ?></div>
    @endif
</div>