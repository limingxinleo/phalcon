{% extends "test/master.volt" %}
{% block content %}
    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
        <?php foreach ($page->items as $item) { ?>
        <tr>
            <td><?php echo $item->id; ?></td>
            <td><?php echo $item->name; ?></td>
        </tr>
        <?php } ?>
    </table>
{% endblock %}