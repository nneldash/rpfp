
				              	</div>
				            </div>
				        </div>
				    </div>
				</div>
            </div>
        </div>


        <div id="coupleModal" class="modal fade" role="dialog" style="z-index: 9999;">
            <div class="modal-dialog modal-lg" style="width: 75%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" style="color: #fff">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>

        <div id="generateReportModal" class="modal fade" role="dialog" style="z-index: 9999;">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" style="color: #fff">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script>
    // loadJs(base_url + 'NewAssets/templateJs', function() {
        // loadJs(base_url + 'assets/js/listCouples.js', function(){
        //     listCoupleModal();
        // });
        loadJs(base_url + 'NewAssets/datatableJs', function() {
            loadJs(base_url + 'NewAssets/datatableBtJs', function() {
                loadJs(base_url + 'NewAssets/datatableRpJs', function() {
                    loadJs(base_url + 'NewAssets/datatableBtrpJs.js', function() {
                    });
                });
            });
        });
    // });
</script>
