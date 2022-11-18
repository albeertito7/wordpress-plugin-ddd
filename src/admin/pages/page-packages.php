<?php

$blog_id = get_current_blog_id();

?>

<style>
    .customer-photo {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-size: 32px 35px;
        background-position: center center;
        vertical-align: middle;
        line-height: 32px;
        box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
        margin-left: 5px;
    }
    .customer-name {
        display: inline-block;
        vertical-align: middle;
        line-height: 32px;
        padding-left: 3px;
    }
    .k-grid tr .checkbox-align {
        text-align: center;
        vertical-align: middle;
    }
    .product-photo {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-size: 32px 35px;
        background-position: center center;
        vertical-align: middle;
        line-height: 32px;
        box-shadow: inset 0 0 1px #999, inset 0 0 10px rgba(0,0,0,.2);
        margin-right: 5px;
    }
    .product-name {
        display: inline-block;
        vertical-align: middle;
        line-height: 32px;
        padding-left: 3px;
    }
    .k-rating-container .k-rating-item {
        padding: 4px 0;
    }
    .k-rating-container .k-rating-item .k-icon {
        font-size: 16px;
    }
    .dropdown-country-wrap {
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        white-space: nowrap;
    }
    .dropdown-country-wrap img {
        margin-right: 10px;
    }
    #grid .k-grid-edit-row > td > .k-rating {
        margin-left: 0;
        width: 100%;
    }
    .action-grid-button {
        font-size: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
        color: white;
        outline: none;
        text-align: center;
        padding: .375rem .75rem
        font-weight: 400;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .k-grid tbody td>.k-button {
        color: white;
        background-image: none;
    }
    .action-grid-button.edit-package, .k-grid tbody td>.k-grid-edit {
        background-color: #28a745;
        border-color: #28a745;
    }
    .action-grid-button.copy-package, .k-grid tbody td>.k-grid-copy  {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    .action-grid-button.delete-package, .k-grid tbody td>.k-grid-delete, .k-grid tbody td>.k-grid-remove {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<div class="wrap">
    <h1 style="margin-bottom: 20px;"><?php _e('Packages', 'entities'); ?></h1>
    <div id="grid"></div>
</div>
