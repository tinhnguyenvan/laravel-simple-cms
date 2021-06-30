<tr data-node-id="{{$item->id}}" data-node-pid="{{$item->parent_id}}">
    <td>
        <a href="{{ admin_url('classified_categories/'.$item->id.'/edit') }}">
            {{ $item->title }}
            <i class="fa fa-edit"></i>
        </a>
    </td>
    <td>
        {{ $item->slug }}
    </td>
    <td class="text-center">
        @if($item->image_url)
            <img src="{{ asset('storage'.$item->image_url) }}" class="img-table img-thumbnail"/>
        @endif
    </td>
    <td>
        {{ $item->total_usage }}
    </td>
    <td>
        {{ $item->created_at->format('d/m/Y H:s') }}
    </td>
    <td class="text-right">
        <form method="post" action="{{ admin_url('classified_categories/'.$item->id ) }}">
            @csrf
            @method('DELETE')
            @if($item->level < 2)
            <a href="{{ admin_url('classified_categories/create?parent_id='.$item->id) }}"
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