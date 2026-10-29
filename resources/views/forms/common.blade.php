{{--
    Other records (certified copies, results, etc.).
    js/home reads each checked name="document_type" box's .form-check label; "Others" takes #document_type.
--}}
@php
    $c = (isset($certificates) && $certificates) ? $certificates : null;
    $documents = [
        'Certified Machine Copy', 'OR Record', 'Laboratory Results', 'Xray Results', 'Discharge Summary',
        'Histopath Result', 'Fetal Death Certificate', 'Death Certificate', 'SSS', 'Insurance Claims',
    ];
    $is_other = $c && !in_array($c->specific_document, $documents);
@endphp
<div class="cert-form">
    @include('forms.partials.head', ['title' => 'Other records', 'icon' => 'files', 'lock_issued' => true])
    <div class="row g-3">
        <div class="col-lg-7">
            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-file-earmark-text"></i> Document requested</h6>
                <div class="choice-group">
                    @foreach($documents as $i => $document)
                        <div class="form-check choice">
                            <input class="form-check-input" type="checkbox" name="document_type" id="document_type_{{ $i }}"
                                   @if($c && $c->specific_document == $document) checked @endif>
                            <label class="form-check-label" for="document_type_{{ $i }}">{{ $document }}</label>
                        </div>
                    @endforeach
                    <div class="form-check choice choice-other">
                        <input class="form-check-input" type="checkbox" name="document_type" id="document_type_other"
                               @if($is_other) checked @endif>
                        <label class="form-check-label" for="document_type_other">Others</label>
                        <input type="text" class="form-control form-control-sm" id="document_type" placeholder="Specify"
                               aria-label="Other document" value="{{ $is_other ? $c->specific_document : '' }}"/>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <h6 class="section-title"><i class="bi bi-person"></i> Patient &amp; requester</h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="patient">Name of patient <span class="req">*</span></label>
                        <input type="text" class="form-control" id="patient" value="{{ $c ? $c->patient : '' }}"/>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label" for="requesting_person">Requested by <span class="req">*</span></label>
                        <input type="text" class="form-control" id="requesting_person"
                               value="{{ $c ? $c->requesting_person : '' }}"/>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label" for="relationship">Relationship</label>
                        <input type="text" class="form-control" id="relationship" value="{{ $c ? $c->relationship : '' }}"/>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-lg-5">
            @include('forms.partials.physician', ['with_designation' => true, 'hidden' => true])
            @include('forms.partials.billing')
        </div>
    </div>
</div>
