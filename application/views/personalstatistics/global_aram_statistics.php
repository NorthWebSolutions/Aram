                                <table class="table stat_panel">
                <thead>
                    <tr><th colspan="2" class="text-center "><h3><?php echo ucfirst($this->session->username); ?><br />
                                <small>Aram stats:</small></h3></th></tr>

                </thead>
                <tbody>                    
<tr>
                        <td colspan="2"><h3>Database statistics:</h3></td>

                    </tr>
                    <tr> 
                        <td>Total Mach:</td>
                        <td><?php echo "$totalMach"; ?></td>
                    </tr>
                    <tr>
                        <td>Wins:</td>
                        <td><?php echo "$winsAllFromDB"; ?></td>
                    </tr>
                    <tr>
                        <td>Loses:</td>
                        <td><?php echo "$losesAllFromDB"; ?></td>
                    </tr>
                    <tr>
                        <td>Win Percent:</td>
                        <td><?php echo "$winPercent%"; ?></td>
                    </tr>


                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    


                    
                </tbody>
            </table>