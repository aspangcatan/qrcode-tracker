{{--
    A list js/home adds rows to (diagnosis, chief complaint, medication, plan).
    js/home reads each row's first <td> and appends rows with the same three cells.
    Params: $list_id, $heading, $icon, $trigger (id of the modal-footer button that opens the editor),
            $items, $field, $edit_fn, $delete_fn, $empty_text, $required.
--}}
<section class="form-section">
    <div class="section-head">
        <h6 class="section-title">
            <i class="bi bi-{{ $icon ?? 'clipboard2-pulse' }}"></i> {{ $heading }}
            @if($required ?? false) <span class="req">*</span> @endif
        </h6>
        <button type="button" class="btn btn-sm btn-tonal" onclick="document.getElementById('{{ $trigger }}').click()">
            <i class="bi bi-plus-lg"></i> Add
        </button>
    </div>
    <table class="item-list" id="{{ $list_id }}">
        @if(isset($items) && $items)
            @foreach($items as $item)
                <tr>
                    <td style='width: 90%'>{!! $item->{$field} !!}</td>
                    <td style='width: 5%'>
                        <button type="button" class='btn btn-sm btn-transparent' onClick='{{ $edit_fn }}(this)'><i
                                class='bi bi-pencil-fill text-success'></i></button>
                    </td>
                    <td style='width: 5%'>
                        <button type="button" class='btn btn-sm btn-transparent' onClick='{{ $delete_fn }}(this)'><i
                                class='bi bi-trash-fill text-danger'></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
    <p class="item-empty">{{ $empty_text ?? 'Nothing added yet.' }}</p>
</section>
