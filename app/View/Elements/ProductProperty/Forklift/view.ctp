<table class="table">
    <tr>
        <td class="fit-content" style="border-top-style: none;"><?php echo __('Type'); ?></td>
        <td style="border-top-style: none;"><?php echo h($property['type']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Capacity'); ?></td><td><?php echo h($property['capacity']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Mast'); ?></td><td><?php echo h($property['mast']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Fork'); ?></td><td><?php echo h($property['fork']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Gear'); ?></td><td><?php echo h($this->Flag->forkliftGear($property['gear'])); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Engine'); ?></td><td><?php echo h($this->Flag->forkliftEngine($property['engine'])); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Wheel'); ?></td><td><?php echo h($property['wheel']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Tire'); ?></td><td><?php echo h($property['tire']); ?></td>
    </tr>
    <tr>
        <td><?php echo __('Attachment'); ?></td><td><?php echo h($property['attachment']); ?></td>
    </tr>
</table>