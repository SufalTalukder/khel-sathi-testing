@extends('layouts\layout')
@section('content')
<div class="container-fluid pagecontentbody">
    <div class="pagebody removebg-color">
        <div class="row">
            <div class="col-12">
                <div class="pageheader" id="menu-margin">
                    <h4 class="mb-0">
                        Application Preview
                        <button type="button" data-print="modal"
                            class="btn btn-sm  btn-outline-primary ms-2 float-end rounded-pill"
                            onclick="PrintDoc()"><span class="icons icon-printer"></span> Print</button>
                        <a href="{{ route('dashboard') }}"
                            class="btn btn-outline-danger btn-sm backbtn float-end rounded-pill"><span
                                class="icons icon-arrow-left"></span>Back to Dashboard</a>
                    </h4>
                </div>
                <div class="bhoechie-tab-container">
                    <div class="form-scroll">
                        <div class="nano-content">
                            <div class="card">
                                <div class="card-body">
                                    <div id="prodiv">
                                        <table class="dn" style="width: 100%; margin-bottom: 5px;" border="0">
                                            <tr>
                                                <td colspan="2" align="center"
                                                    style="position: relative; border: 0; padding-bottom: 5px;">
                                                    <div style="border-bottom: 0px solid #000; padding-bottom: 2vw;">
                                                        <img id="logo"
                                                            src="{{ asset('') }}/assets_admin/images/logo.png"
                                                            style="display:none;position: absolute; width: 70px; top: -7px; left: 0;" />
                                                        <div style="font-size: 25px; font-weight: bold;">
                                                            <!-- Department of Sports -->
                                                            Khel Sathi Portal / खेल साथी पोर्टल
                                                        </div>
                                                        <div style="font-size: 18px; font-weight: bold;">
                                                            Government of Uttar Pradesh/उत्तर प्रदेश सरकार
                                                        </div>
                                                        <div style="font-size: 18px; font-weight: bold;">Application
                                                            Form for Eklavya Krida Kosh/एकलव्य क्रीड़ा कोष के लिए
                                                            नामांकन हेतु आवेदन </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                        @php
                                        $tot_q = isset($total_queries) ? $total_queries : (isset($queryData) ? count($queryData) : 0);
                                        $opn_q = isset($open_queries) ? $open_queries : (isset($queryData) ? $queryData->filter(function($i){ return ($i->is_closed == 0 || is_null($i->is_closed)); })->count() : 0);
                                        $isRejectedOrQuery = ($articles->form_status == 2 || $opn_q > 0);
                                        $isFinalSubmitted = ($articles->final_submit == 1);
                                        $canEdit = (!$isFinalSubmitted) || $isRejectedOrQuery;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2"
                                            @if ($articles->final_submit != 1) style="display: none" @endif>
                                            <div>
                                                <strong>Application no. / आवेदन संख्या -</strong> <b
                                                    id="application_no">{{ $articles->application_no }}</b>
                                            </div>
                                            <div>
                                                <strong>Application Status / आवेदन की स्थिति -</strong>
                                                <b>
                                                    @if ($articles->form_status == 2)
                                                    <span class="badge bg-danger text-white">Rejected</span>
                                                    @elseif ($opn_q > 0)
                                                    <span class="badge bg-primary text-white">Query Raised</span>
                                                    @elseif ($articles->form_status == 1)
                                                    <span class="badge bg-success text-white">Approved</span>
                                                    @elseif ($tot_q > 0)
                                                    <span class="badge bg-success text-white">Query Resolved</span>
                                                    @elseif ($articles->final_submit == 1)
                                                    <span class="badge bg-info text-white">In Process</span>
                                                    @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                    @endif
                                                </b>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                style="border-collapse: collapse; width: 100%;">
                                                <tr>
                                                    <td colspan="6" class="bg-light"><strong>Basic Details/सामान्य
                                                            विवरण</strong></td>
                                                    <!--Basic Details-->
                                                </tr>
                                                <tr>
                                                    <td style="width: 15%"><strong> Purpose/उद्देश्य</strong></td>
                                                    <td style="width: 20%">{{ $articles->purpose }}</td>
                                                    <td style="width: 15%"><strong>Full Name/पूरा नाम</strong></td>
                                                    <td style="width: 20%">{{ Auth::user()->fullname }}</td>
                                                    <td rowspan="5" colspan="2">
                                                        <div class="text-center" style="padding: 5px;" align="center">
                                                            <img src="{{ asset('storage/award/') . '/' . $articles->photograph_doc }}"
                                                                class="img-fluid" style="width: 140px;" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email ID/ईमेल पता</strong></td>
                                                    <td>{{ Auth::user()->email }}</td>
                                                    <td><strong>Mobile Number/मोबाइल नंबर</strong></td>
                                                    <td>{{ Auth::user()->mobile }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="bg-light"><strong>Personal
                                                            Details/व्यक्तिगत
                                                            विवरण</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Father's Name/पिता का नाम</strong></td>
                                                    <td>{{ $articles->father_name }}</td>
                                                    <td><strong>Mother's Name/माता का नाम</strong></td>
                                                    <td>{{ $articles->mother_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Gender/लिंग</strong></td>
                                                    <td>
                                                        {{ $articles->gender }}
                                                    </td>
                                                    <td><strong>Date of Birth/जन्म तिथि</strong></td>
                                                    <td>{{ $articles->dob }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Aadhaar No./आधार कार्ड</strong></td>
                                                    <td>{{ $articles->aadhar_no }}</td>
                                                    <td><strong>Nationality/राष्ट्रीयता</strong></td>
                                                    <td>{{ $articles->nationality }}</td>
                                                    <td rowspan="2" colspan="2" align="center"><img
                                                            src="{{ asset('storage/award/') . '/' . $articles->signature_doc }}"
                                                            style="width: 90px;margin: auto;"></td>
                                                </tr>

                                                <tr>
                                                    <td><strong>Alternate Phone Number/वैकल्पिक फ़ोन नंबर</strong></td>
                                                    <td>{{ $articles->mobile }}</td>
                                                    <td><strong>Sports Name/खेल का नाम</strong></td>
                                                    <td>{{ $articles->sport_name }}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6" class="bg-light"><strong>Permanent
                                                            Address</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Flat No. / House No. / फ़्लैट नं./मकान नं.</td>
                                                    <td>{{ $articles->permanent_flat_no }}</td>
                                                    <td><b>Complete Address / पूर्ण पता</td>
                                                    <td>{{ $articles->permanent_address }}</td>
                                                    <td><b>District / ज़िला</b></td>
                                                    <td>{{ districtName($articles->permanent_district) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Pincode / पिन कोड</b></td>
                                                    <td>{{ $articles->permanent_pincode }}</td>
                                                    <td><b>State/राज्य</b></td>
                                                    <td>Uttar Pradesh</td>
                                                </tr>

                                                <td colspan="6"><strong>Correspondence Address</strong></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Flat No. / House No. / फ़्लैट नं./मकान नं.</td>
                                                    <td>{{ $articles->present_flat_no }}</td>
                                                    <td><b>Complete Address / पूर्ण पता</td>
                                                    <td>{{ $articles->present_address }}</td>
                                                    <td><b>District / ज़िला</b></td>
                                                    <td>{{ districtName($articles->present_district) }}</td>

                                                </tr>
                                                <tr>
                                                    <td><b>Pincode / पिन कोड</b></td>
                                                    <td>{{ $articles->present_pincode }}</td>
                                                    <td><strong>State/राज्य</strong></td>
                                                    <td>{{ stateName($articles->present_state) }}</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>

                                                {{-- Diploma Scholarship Section --}}
                                                @if ($articles->purpose === 'Diploma Scholarship')
                                                <tr>
                                                    <td colspan="6" class="bg-light">
                                                        <strong>Diploma Scholarship
                                                            Details & Certificate(s)/डिप्लोमा स्कॉलरशिप की जानकारी
                                                            और
                                                            सर्टिफिकेट
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered table-sm">
                                                            <thead>
                                                                <tr style="background-color: #dfdacd;">
                                                                    <th style="width:5%">S.No. / क्र.सं.</th>
                                                                    <th>Details & Documents / विवरण और दस्तावेज़
                                                                    </th>
                                                                    <th style="width:10%">Details & Uploads / विवरण और
                                                                        अपलोड</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1. </td>
                                                                    <td>Institute/संस्था <span
                                                                            class="text-danger">*</span></td>
                                                                    <td>{{ $articles->diploma_institute }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2. </td>
                                                                    <td>Session/सत्र <span
                                                                            class="text-danger">*</span></td>
                                                                    <td>{{ $articles->diploma_session }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3. </td>
                                                                    <td>Course/अवधि <span
                                                                            class="text-danger">*</span></td>
                                                                    <td>{{ $articles->diploma_course }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4. </td>
                                                                    <td>Fee/Bank Receipt upload/फ़ीस/बैंक रसीद अपलोड
                                                                        करें <span class="text-danger">*</span>
                                                                    </td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/diploma_fee_bank_receipt/') }}/{{ $articles->diploma_fee_bank_receipt }}"
                                                                            target="_blank"
                                                                            class="btn btn-success btn-xs">Uploaded</a>
                                                                    </td>
                                                                </tr>
                                                                @if (isset($articles->diploma_semester_certificate) && $articles->diploma_semester_certificate !== null)
                                                                <tr>
                                                                    <td>5. </td>
                                                                    <td> Semester Certificate/सेमेस्टर
                                                                        सर्टिफ़िकेट
                                                                    </td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/diploma_semester_certificate/') }}/{{ $articles->diploma_semester_certificate }}"
                                                                            target="_blank"
                                                                            class="btn btn-success btn-xs">Uploaded</a>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                @endif

                                                <tr>
                                                    <td colspan="6" class="bg-light"><strong>Educational
                                                            Qualification & Certificate/शिक्षात्मक & योग्यता प्रमाण
                                                            पत्र</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered table-sm">
                                                            <thead>
                                                                <tr style="background-color: #dfdacd;">
                                                                    <th style="width:5%">S.No. / क्र.सं.</th>
                                                                    <th>Documents / दस्तावेज़</th>
                                                                    <th style="width:10%">Upload</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if ($articles->qualification == '10' || $articles->qualification == '12')
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>High School Certificate/हाई स्कूल प्रमाण
                                                                        पत्र</td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/high_school_certificate/') }}/{{ $articles->high_school_certificate }}"
                                                                            target="_blank"
                                                                            class="btn btn-success btn-xs">Uploaded</a>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Highest Education Qualification/उच्चतम शैक्षणिक
                                                                        योग्यता</td>
                                                                    <td>
                                                                        @if ($articles->qualification == '10')
                                                                        10th/High School
                                                                        @elseif($articles->qualification == '12')
                                                                        12th / Intermediate
                                                                        @elseif($articles->qualification == 'graduation')
                                                                        Graduation
                                                                        @elseif($articles->qualification == 'post_graduation')
                                                                        Post-Graduation
                                                                        @elseif($articles->qualification == 'diploma')
                                                                        Diploma (NIS/LNIPE)
                                                                        @elseif($articles->qualification == 'researcher')
                                                                        Researcher
                                                                        @elseif($articles->qualification == 'other')
                                                                        Other
                                                                        @endif
                                                                        @if ($articles->qualification == 'other')
                                                                        </br> {{ $articles->other_qualification }}
                                                                        @endif

                                                                    </td>
                                                                </tr>
                                                                @if ($articles->qualification != '10' && $articles->qualification != '12')
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Certificate of Highest Educational
                                                                        Qualification/उच्चतम शैक्षणिक योग्यता का
                                                                        प्रमाणपत्र</td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/highest_qualification_certificate/') }}/{{ $articles->highest_qualification_certificate }}"
                                                                            target="_blank"
                                                                            class="btn btn-success btn-xs">Uploaded</a>
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Domicile Certificate of UP/यूपी का निवास प्रमाण
                                                                        पत्र
                                                                    </td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/domicile_certificate/') }}/{{ $articles->domicile_certificate }}"
                                                                            target="_blank"
                                                                            class="btn btn-success btn-xs">Uploaded</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td> Notary Affidavit/ नोटरी शपथ पत्र
                                                                    </td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/notary_affidavit_doc/') }}/{{ $articles->notary_affidavit_doc }}"
                                                                            target="_blank"
                                                                            class="btn btn-success btn-xs">Uploaded</a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="6" class="bg-light"><strong>Awards &
                                                            Achievements/पुरस्कार और उपलब्धियां</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered table-sm awardtable">
                                                            <thead>
                                                                <tr>
                                                                    <td rowspan="2"><label>Type of Competition
                                                                            <br>प्रतियोगिता का प्रकार</label> <span
                                                                            class="text-danger">*</span>
                                                                    </td>
                                                                    <td rowspan="2"><label>Event Type<br>आयोजन का
                                                                            प्रकार</label> <span
                                                                            class="text-danger">*</span>
                                                                    </td>
                                                                    <td rowspan="2"><label>Event Name<br>आयोजन का
                                                                            नाम</label> <span
                                                                            class="text-danger">*</span>
                                                                    </td>
                                                                    <td rowspan="2"><label>Earned Medals<br>अर्जित
                                                                            पदक</label> <span
                                                                            class="text-danger">*</span>
                                                                    </td>
                                                                    <td colspan="2" class="text-center">
                                                                        <label>Period
                                                                            of
                                                                            Competition<br>प्रतियोगिता की अवधि</label>
                                                                        <span class="text-danger">*</span>
                                                                    </td>
                                                                    <td rowspan="2"><label>Venue Name</br>स्थल का
                                                                            नाम</label> <span class="text-danger">*
                                                                        </span></td>
                                                                    <td rowspan="2"><label>Upload Relevant
                                                                            Certificate<br>प्रासंगिक प्रमाण पत्र अपलोड
                                                                            करें<span class="text-danger">*</span>
                                                                        </label>
                                                                    </td>
                                                                    <td rowspan="2"><label>Sport Event
                                                                            Detail</br>खेलकूद
                                                                            प्रतियोगिता का विवरण<span
                                                                                class="text-danger">*</span></label>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td><label>From </label>
                                                                    </td>
                                                                    <td><label>To </label>
                                                                    </td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @foreach ($sport_achievement as $item)
                                                                <tr>
                                                                    <td class="form-group">
                                                                        {{ $item->comp }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($item->event_type == 1)
                                                                        Individual
                                                                        @elseif($item->event_type == 2)
                                                                        Team
                                                                        @else
                                                                        Both
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $item->event }}</td>
                                                                    <td>{{ $item->earned_medals }}</td>
                                                                    <!--  -->
                                                                    <td>
                                                                        {{ $item->competition_from_date }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->competition_to_date }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->sport_place }}
                                                                    </td>
                                                                    <td style="text-align:center">
                                                                        @if ($item->sport_achievement_docs != '')
                                                                        <a href="{{ url('storage/eklavya_kreeda_kosh', $item->sport_achievement_docs) }}"
                                                                            target="_blank">
                                                                            <!-- <span class="btn btn-success btn-xs"> Uploaded</span> -->
                                                                            <i class="fa fa-download"></i>
                                                                        </a>
                                                                        @else
                                                                        <strong
                                                                            class="btn btn-danger btn-xs">Not
                                                                            Uploaded</strong>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        {{ $item->event_details }}
                                                                    </td>
                                                                    <!--  -->
                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="bg-light"><strong>Account
                                                            Information/खाता संबंधी जानकारी</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">
                                                        <table class="table table-bordered table-sm">
                                                            <thead>
                                                                <tr style="background-color: #dfdacd;">
                                                                    <th style="width:25%">Bank Name/बैंक का नाम </th>
                                                                    <th style="width:25%">IFSC Code/आईएफएससी कोड</th>
                                                                    <th style="width:25%">Branch/शाखा</th>
                                                                    <th style="width:25%">Bank Account Number/बैंक खाता
                                                                        संख्या</th>
                                                                    <th style="width:25%">Front page of Passbook/पासबुक
                                                                        का
                                                                        फ्रंट पेज</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $articles->bank_name }}</td>
                                                                    <td>{{ $articles->ifsc_code }}</td>
                                                                    <td>{{ $articles->bank_branch }}</td>
                                                                    <td>{{ $articles->account_no }}</td>
                                                                    <td><a href="{{ asset('eklavya_krida_kosh/front_page_of_passbook/') }}/{{ $articles->front_page_of_passbook }}"
                                                                            target="_blank" " class=" btn btn-success btn-xs">Uploaded</a></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <td colspan="6" class="bg-light"><strong>Declaration</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">I hereby declare that I have read all terms & conditions, eligibility criteria and other relevant information related to the Application and abide by them. I also declare that all the above particulars are true to the best of my knowledge. If any of my facts are found to be wrong or incorrect, my application shall be liable for rejection and I shall be solely held responsible for it.<br>मैं एतद्द्वारा घोषणा करता/करती हूं कि मैंने आवेदन से संबंधित सभी नियम और शर्तें, पात्रता मानदंड और अन्य प्रासंगिक जानकारी पढ़ ली हैं एवं उनका पालन करता/करती हूं। मैं यह भी घोषणा करता/करती हूं कि उपरोक्त सभी विवरण मेरे अनुसार सत्य व सही हैं। यदि मेरा कोई भी तथ्य गलत अथवा असत्य पाया जाता है, तो मेरा आवेदन अस्वीकृत किया जा सकता है और इसके लिए पूर्णतः मैं स्वयं उत्तरदायी ठहराया जाऊंगा/जाऊंगी।
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" align="center">
                                                        <input type="checkbox" @if ($isFinalSubmitted && !$canEdit) disabled checked="checked" @endif id="player_coachChecked" />
                                                        &nbsp; <b>I Agree</b>
                                                    </td>
                                                </tr>
                                            </table>




                                        </div>
                                        <?php $checkk = form_date_status(7); ?>


                                        @if ($checkk == 0)
                                        <div class="row justify-content-center">
                                            <div class="col-md-2 d-grid">
                                                <h3 class="text-danger"> Form Not
                                                    Available</h3>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row justify-content-center">
                                            @if ($canEdit)
                                            <div class="col-md-2 col-6 d-grid">
                                                <a href="{{ url('eklavya_kreeda_kosh') }}/{{ $articles->application_no }}"
                                                    class="btn btn-outline-primary btn-sm" style="border-color: #6f125a; color: #6f125a;">Edit/संशोधन
                                                    करें</a>
                                            </div>
                                            <div class="col-md-2 col-6 d-grid">
                                                <button
                                                    class="btn btn-info btn-sm text-white" style="background-color: #00bcd4; border-color: #00bcd4;"
                                                    id="player_coachFinal">Final
                                                    Submit/अंतिम रूप से दर्ज
                                                    करें</button>
                                            </div>
                                            @else
                                            @php
                                            $cannotSubmitMsg = ($opn_q > 0)
                                            ? 'Your open query is currently unresolved/pending, so final submission is not possible. / आपकी क्वेरी अभी भी खुली (लंबित) है, अतः अंतिम रूप से आवेदन सबमिट करना संभव नहीं है।'
                                            : 'Your application has already been submitted and is currently under process. / आपका आवेदन पहले ही अंतिम रूप से जमा किया जा चुका है और प्रक्रियाधीन है।';
                                            @endphp
                                            <div class="col-md-2 col-6 d-grid">
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-sm" id="cannotEditBtn" style="border-color: #6c757d; color: #6c757d; cursor: not-allowed; opacity: 0.65;" title="Application is already submitted. Edit is disabled unless application status is Rejected or Query Raised">Edit/संशोधन
                                                    करें</button>
                                            </div>
                                            <div class="col-md-2 col-6 d-grid">
                                                <button type="button"
                                                    class="btn btn-sm text-white" id="cannotFinalSubmitBtn" data-msg="{{ $cannotSubmitMsg }}" style="background-color: #5a22ac; border-color: #5a22ac; color: #ffffff !important; cursor: not-allowed; opacity: 0.75;" title="{{ $cannotSubmitMsg }}">Final
                                                    Submit/अंतिम रूप से दर्ज
                                                    करें</button>
                                            </div>
                                            @endif
                                            <!-- <div class="col-md-2 d-grid">
                                                <a class="btn btn-outline-info rounded-pill" href="Payment.html">Pay Registration Fee</a>
                                            </div> -->
                                        </div>
                                    </div>
                                    @endif
                                    @if (isset($articles) && ($articles->form_status == 1 || $articles->form_status == 2))
                                    @if (count($queryData) > 0)
                                    <x-query-details :queryData="$queryData" :isApplicant="true" />
                                    @endif
                                    @else
                                    <x-query-details :queryData="$queryData" :isApplicant="true" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="player_coachFinalWarning" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h3> Are you sure?</h3>
                <p>The application will be submitted successfully.</p>
                <p>
                    <a href="javascript:void(0)" id="final_submit"
                        class="btn btn-outline-success rounded-pill">Yes</a>
                    <a type="button" class="btn btn-outline-danger rounded-pill" data-bs-dismiss="modal">No</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<style>
    #cannotFinalSubmitBtn {
        background-color: #5a22ac !important;
        border-color: #5a22ac !important;
        color: #ffffff !important;
        cursor: not-allowed !important;
        opacity: 0.75 !important;
    }

    #cannotFinalSubmitBtn:hover {
        background-color: #4a1990 !important;
        border-color: #4a1990 !important;
        color: #ffffff !important;
    }
</style>
<script>
    $(document).on('click', '#cannotEditBtn', function() {
        var editWarnMsg = 'Application is already submitted. Modification/Edit is allowed only if the application is Rejected or a Query is Raised. / आवेदन पहले ही जमा किया जा चुका है। संशोधन केवल आवेदन अस्वीकृत होने या क्वेरी पूछे जाने पर ही संभव है।';
        if (typeof warning === 'function') {
            warning(editWarnMsg);
        } else if (typeof info === 'function') {
            info(editWarnMsg);
        }
        return false;
    });

    $(document).on('click', '#cannotFinalSubmitBtn', function() {
        var warnMsg = $(this).attr('data-msg') || 'Your application has already been submitted and is currently under process. / आपका आवेदन पहले ही अंतिम रूप से जमा किया जा चुका है और प्रक्रियाधीन है।';
        if (typeof warning === 'function') {
            warning(warnMsg);
        } else if (typeof error === 'function') {
            error(warnMsg);
        }
        return false;
    });

    $('#player_coachFinal').click(function() {
        if ($('#player_coachChecked').is(':checked')) {
            $('#player_coachFinalWarning').modal('toggle');
        } else {
            error('Please click on the Declaration Checkbox (I Agree) and then proceed to submit. / कृपया घोषणा के चेकबॉक्स (I Agree) पर क्लिक करें एवं तदोपरांत आगे बढ़ें।');
        }
        return false;
    });

    $('#final_submit').click(function() {
        if (!$('#player_coachChecked').is(':checked')) {
            $('#player_coachFinalWarning').modal('hide');
            error('Please click on the Declaration Checkbox (I Agree) and then proceed to submit. / कृपया घोषणा के चेकबॉक्स (I Agree) पर क्लिक करें एवं तदोपरांत आगे बढ़ें।');
            return false;
        }
        var appNo = "<?php echo !empty($articles->application_no) ? $articles->application_no : ''; ?>";
        var baseUrl = typeof ajaxUrl !== 'undefined' && ajaxUrl ? ajaxUrl : "{{ url('') }}";
        if (window.location.pathname.indexOf('/application/') !== -1 && baseUrl.indexOf('/application') === -1) {
            baseUrl = window.location.origin + '/application';
        }
        var actionUrl = baseUrl + "/eklavya_kreeda_kosh/final_submit/" + appNo;
        // console.log(actionUrl)
        $.ajax({
            type: "GET",
            url: actionUrl,
            dataType: "json",
            success: function(res) {
                $('#player_coachFinalWarning').modal('hide');
                if (res && res.error == false) {
                    if (typeof success === 'function') {
                        success(res.msg);
                    }
                    var destUrl = res.url || (baseUrl + "/dashboard");
                    if (window.location.pathname.indexOf('/application/') !== -1 && destUrl.indexOf('/application') === -1) {
                        destUrl = window.location.origin + '/application/dashboard';
                    }
                    setTimeout(function() {
                        window.location.href = destUrl;
                    }, 1200);
                } else {
                    var errMsg = (res && res.msg) ? res.msg : 'Submission failed. Please try again.';
                    if (typeof error === 'function') {
                        error(errMsg);
                    }
                }
            },
            error: function(xhr) {
                $('#player_coachFinalWarning').modal('hide');
                var errTxt = 'Something went wrong while submitting. Please try again. / सबमिट करते समय कुछ त्रुटि हुई। कृपया पुनः प्रयास करें।';
                if (xhr && xhr.responseJSON && xhr.responseJSON.msg) {
                    errTxt = xhr.responseJSON.msg;
                }
                if (typeof error === 'function') {
                    error(errTxt);
                }
            }
        });
    });
</script>
@endpush