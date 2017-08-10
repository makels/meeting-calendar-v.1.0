<div id="event_wnd" class="event-wrapper">
    <div class="event-title background">{fa_icon name="calendar"} Event</div>
    <div class="event-body">
        <input type="hidden" id="event_id" />
        <input type="hidden" id="event_owner_id" />
        <input type="hidden" id="user_id" value="{$user->id}"/>
        <input type="hidden" id="user_display_name" value="{$user->display_name}"/>
        <input type="hidden" id="user_su" value="{if $user->is_admin() === true}1{else}0{/if}"/>

        <label for="event_owner">Author:</label>
        <input type="text" id="event_owner" disabled value="{$user->display_name}" /><br>

        <label for="event_title">Title:</label>
        <input type="text" id="event_title" /><br>

        <label for="event_start">Start date & time:</label>
        <input class="datetimepicker" type="text" id="event_start" /><br>

        <label for="event_end">End date & time:</label>
        <input class="datetimepicker" type="text" id="event_end" /><br>

        <label for="event_status">Status:</label>
        <select id="event_status">
            <option value="new" selected>New</option>
            <option value="in-progress">In progress</option>
            <option value="done">Done</option>
        </select><br>

        <div class="event_colors">
            <label for="event_color">Color background:</label>
            <input type="text" id="event_color" /><br>

            <label for="event_color">Color text:</label>
            <input type="text" id="event_color_text" /><br>
        </div>

        <label for="event_description">Description:</label><br>
        <textarea id="event_description"></textarea>

    </div>
    <div class="buttons-wrapper writable">
        <button id="event_delete">{fa_icon name="remove"}Delete Event</button>
        <button id="event_cancel">{fa_icon name="close"}Cancel</button>
        <button id="event_save">{fa_icon name="save"}Save</button>
    </div>

    <div class="buttons-wrapper readonly">
        <button id="event_close">{fa_icon name="close"}Close</button>
    </div>
</div>