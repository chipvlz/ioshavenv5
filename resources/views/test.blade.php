hello world

@can('administrator')
<div>I can do everything</div>
@endcan


@can('manage roles')
<div>I can manage roles</div>
@else
<div>I cannot manage roles</div>
@endcan
