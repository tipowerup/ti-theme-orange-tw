<div>
    @if($count > 0)
        <span class="absolute -top-2 -right-2 bg-primary text-white text-xs rounded-full min-w-[1.125rem] h-[1.125rem] px-1 flex items-center justify-center text-[10px] font-bold leading-none">
            {{ $count > 99 ? '99+' : $count }}
        </span>
    @endif
</div>
