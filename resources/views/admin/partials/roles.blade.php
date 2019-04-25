@forelse ($user->roles as $role)
    <button type="button" class="btn btn-{{$role->getClass()}} btn-sm">
            <span class="badge badge-transparent">{{$role->level}}</span> {{ $role->name }} 
    </button>
@empty
    No roles yet
@endforelse