<?php
//lucky draw winners
function lucky_draw_winner_preview_page()
{
    function get_lucky_draw_entries()
    {
        $api_url = get_site_url() . '/wp-json/lucky-draw/v1/get-entries'; // Replace with your actual API endpoint URL
        $response = wp_remote_get($api_url);
        if (is_wp_error($response)) {
            return array(); // Return an empty array in case of error
        }
        $body = wp_remote_retrieve_body($response);
        $entries = json_decode($body);

        return $entries;
    }

    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <?php
                $entries = get_lucky_draw_entries();
                // Get the headings from the first entry
                $firstEntry = reset($entries);
                $tableHeaders = array_keys((array)$firstEntry);

                // Check if the delete_table form has been submitted
                $deletion_completed = false;
                if (isset($_POST['delete_table'])) {
                    if (isset($_POST['confirmation'])) {
                        lucky_draw_delete_all_entries();
                        $deletion_completed = true;
                    } else {
                        echo "Please confirm your action.";
                    }
                }

                ?>
                <h1 class="text-center fw-bolder">LUCKY DRAW WINNERS</h1>
                <div class="mt-4">
                    <?php if (!$deletion_completed && $entries) { ?>
                        <table class="mt-3 table table-hover table-responsive table-striped-columns border border-1 border-dark border-opacity-25 rounded-2">
                            <thead>
                            <tr>
                                <?php foreach ($tableHeaders as $header) : ?>
                                    <th><?= $header ?></th>
                                <?php endforeach; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($entries as $entry) : ?>
                                <tr>
                                    <?php foreach ($entry as $value) : ?>
                                        <td><?= str_replace("'", "", $value) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <form method="POST" class="d-flex flex-column">
                            <label for="confirmation">
                                <input class="form-check-input" type="checkbox" name="confirmation" id="confirmation">
                                I confirm that I want to delete the table.
                            </label>
                            <div>
                                <button class="btn btn-danger fs-6 mt-4" type="submit" name="delete_table">Delete
                                    Table
                                </button>
                            </div>
                        </form>
                    <?php } ?>
                </div>


            </div>
        </div>
    </div>

<?php }