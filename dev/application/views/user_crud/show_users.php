<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-2-2016
 * Time: 13:08
 */
?>

<div class="table-responsive ">
    <table class="table table table-hover table-bordered" id="t2" width="100%">
        <thead>
        <tr>
            <th class="hidden-xs">#</th>
            <th>Naam</th>
            <th>E-mailadres</th>
            <th class="hidden-xs">Klas</th>
            <th>Rol</th>
            <th>Wijzig</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < count($gebruikers); ++$i) { ?>
            <tr>

                <td class="hidden-xs"><?php echo($page + $i + 1); ?></td>
                <td><?php echo $gebruikers[$i]->name; ?></td>
                <td><?php echo $gebruikers[$i]->email; ?></td>
                <td class="hidden-xs"><?php echo $gebruikers[$i]->klas; ?></td>

                <!-- if date beyond march - second reportcard should be accessible. -->

                <td>

                    <?php echo $gebruikers[$i]->rolnaam; ?>
                </td>
                <td>
                    <a href="/dashboard/edit_user/<?= $gebruikers[$i]->id; ?>/<?php echo $gebruikers[$i]->rolnaam; ?>"
                       target="_self"><i class="fa fa-pencil"></i> </a>
                </td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
