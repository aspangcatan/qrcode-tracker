{{--
    Who asked for the certificate and why.
    Params: $requester_required, $purpose (null | 'text' | 'select'), $second_options (2nd purpose choices for 'select'),
            $second_blank_last (new certificates list the blank 2nd purpose last, so the first choice is preselected).
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
    $purpose = $purpose ?? null;
    $purposes = [
        'Financial and Medical Assistance Program available in the hospital',
        'School Related Purposes, except for insurance claims or any legal claim',
        'Work Related-Purposes, except for insurance claims or any legal claim',
    ];
    $second_options = $second_options ?? [];
    $blank_last = !$c && ($second_blank_last ?? false);
@endphp
<section class="form-section">
    <h6 class="section-title"><i class="bi bi-chat-square-text"></i> Request</h6>
    <div class="row g-3">
        <div class="col-md-7">
            <label class="form-label" for="requesting_person">Requested by @if($requester_required ?? true)<span class="req">*</span>@endif</label>
            <input type="text" class="form-control" id="requesting_person" placeholder="Name of person requesting"
                   value="{{ $c ? $c->requesting_person : '' }}"/>
        </div>
        <div class="col-md-5">
            <label class="form-label" for="relationship">Relationship</label>
            <input type="text" class="form-control" id="relationship" placeholder="e.g. Self, Mother"
                   value="{{ $c ? $c->relationship : '' }}"/>
        </div>
        @if($purpose === 'text')
            <div class="col-12">
                <label class="form-label" for="purpose">Purpose <span class="req">*</span></label>
                <input type="text" class="form-control" id="purpose" placeholder="What the certificate is for"
                       value="{{ $c ? $c->purpose : '' }}"/>
            </div>
        @elseif($purpose === 'select')
            <div class="col-12">
                <label class="form-label" for="purpose">Purpose <span class="req">*</span></label>
                <select class="form-select" id="purpose">
                    @foreach($purposes as $option)
                        <option @if($c && $c->purpose == $option) selected @endif>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12" id="purpose_container">
                <label class="form-label" for="second_purpose">2nd purpose</label>
                <select class="form-select" id="second_purpose">
                    @unless($blank_last)
                        <option></option>
                    @endunless
                    @foreach($second_options as $option)
                        <option @if($c && $c->second_purpose == $option) selected @endif>{{ $option }}</option>
                    @endforeach
                    @if($blank_last)
                        <option></option>
                    @endif
                </select>
                <div class="form-text">For the Financial and Medical Assistance Program.</div>
            </div>
        @endif
    </div>
</section>
