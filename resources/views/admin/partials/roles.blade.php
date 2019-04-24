@forelse ($user->roles as $role)
    <span><strong>{{$role->level}}:</strong>{{ $role->name }}</span>
@empty
    No roles yet
@endforelse