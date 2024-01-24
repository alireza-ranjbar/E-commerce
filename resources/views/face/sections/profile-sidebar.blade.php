<div class="myaccount-tab-menu nav" role="tablist">

    <a href="{{route('profile.user-account.index')}}" @if(request()->is('profile/user-account')) class="active" @endif>
        <i class="sli sli-user ml-1"></i>
        اطلاعات کاربر
    </a>

    <a href="{{route('profile.orders.index')}}" @if(request()->is('profile/orders')) class="active" @endif>
        <i class="sli sli-basket ml-1"></i>
        سفارشات
    </a>

    <a href="{{route('profile.address.index')}}" @if(request()->is('profile/address')) class="active" @endif>
        <i class="sli sli-map ml-1"></i>
        آدرس ها
    </a>

    <a href="{{route('profile.wishlist.index')}}" @if(request()->is('profile/wishlist')) class="active" @endif>
        <i class="sli sli-heart ml-1"></i>
        لیست علاقه مندی ها
    </a>

    <a href="{{route('profile.comments.index')}}" @if(request()->is('profile/comments')) class="active" @endif>
        <i class="sli sli-bubble ml-1"></i>
        نظرات
    </a>

    <a href="javascript:void(0)" onclick="$('#logout-form').submit()">
        <i class="sli sli-logout ml-1"></i>
        خروج
    </a>
</div>
<form id="logout-form" action="{{route('logout')}}" method="POST">@csrf</form>

