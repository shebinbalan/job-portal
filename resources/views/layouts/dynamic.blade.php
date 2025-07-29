@if (auth()->check() && auth()->user()->role === 'employer')
    @extends('employer-layout.app')
@elseif (auth()->check() && auth()->user()->role === 'seeker')
    @extends('layouts.app')
@endif
