<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->library('helpers/HtmlHelper');
// echo '<pre>';
// print_r($slip);
?>

<div class="body-padding" style="padding-top: 0">
	<form id="advance_search" class="form-horizontal">
        <div class="row">
            <div class="row-md-12">
                <div class="row-md-6 padding-r3p text-left">
                <p class="small"><b>Search by Name</b></p>
                    <div class="row-md-3">
                    <input type="text" name="search_name" value="">
                    </div>
                </div>
                <div class="row-md-6 padding-r3p text-left">
                <p class="small"><b>Search by Class Details</b></p>
                    <div class="row-md-3">
                    <input type="text" name="search_province" value="">
                    </div>
                    <div class="row-md-3">
                    <input type="text" name="search_city" value="">
                    </div>
                    <div class="row-md-3">
                    <input type="text" name="search_class" value="">
                    </div>
                    <div class="row-md-3">
                    <p class="small">
						<b>
							Date Conducted from: 
							<?php
	                            echo HtmlHelper::inputPdf(
	                                $is_pdf,
	                                $slip->DateConducted_from,
	                                "date",
	                                "date_of_Conduct_from",
	                                "padding-l10 underline width-45",
	                                ""
	                            );
	                        ?>
						</b>
					</p>
                    </div>
                    <div class="row-md-3">
                    <p class="small">
						<b>
							Date Conducted to: 
							<?php
	                            echo HtmlHelper::inputPdf(
	                                $is_pdf,
	                                $slip->DateConducted_to,
	                                "date",
	                                "date_of_Conduct_to",
	                                "padding-l10 underline width-45",
	                                ""
	                            );
	                        ?>
						</b>
					</p>
                    </div>
                </div>
            </div>
			<div class="row">
				<div class="col-md-12 text-right">
					<input type="submit" class="search searchAdvance" value="SEARCH" name="searchAdvance" style="width: 15%; margin-bottom: 1%" />
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/searchAdvance.js')?>"></script>