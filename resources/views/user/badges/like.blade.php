@if(\Auth::id() != $target_user->id)
<div>
    <?php $hasStared = \Auth::user()->hasStar($target_user->id) ?>
    <button class="btn btn-default like-button" like-value="{{ $hasStared ? 1 : 0 }}" like-user="{{ $target_user->id }}" type="button">{{ $hasStared ? '取消关注' : '关注' }}</button>
</div>
@endif
