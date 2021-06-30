<tr data-node-id="{{$item->id}}" data-node-pid="{{$item->parent_id}}">
    <td>
        <a href="{{ admin_url('navs/'.$item->id.'/edit') }}">
            {{ $item->title }}
        </a>
    </td>
    <td>
        {{ \App\Models\Nav::dropDownType()[$item->type] ?? '--' }}

        @if(!empty($item->value))
            <a target="_blank" href="{{ url($item->value) }}">
                <i class="fa fa-external-link" aria-hidden="true"></i>
            </a>
        @endif
    </td>
    <td>
        {{ $item->created_at->format('d/m/Y H:s') }}
    </td>
    <td class="text-center">
        {{ $item->order_by ?? 0 }}
    </td>
    <td class="text-right">
        <form method="post" action="{{ admin_url('navs/'.$item->id ) }}">
            @csrf
            @method('DELETE')
            @if($item->level < 2)
                <a href="{{ admin_url('navs/create?parent_id='.$item->id.'&position='.$position) }}"
                   class="btn btn-sm btn-primary">
                    <i class="fa fa-sitemap"></i> {{ trans('nav.add_menu_child') }}
                </a>
            @endif

            <button class="btn btn-danger btn-sm" type="submit">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    </td>
</tr>
