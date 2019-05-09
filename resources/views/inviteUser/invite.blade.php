<div class="modal-content">
    {{-- <div class="modal-header">
        <h4 class="modal-title">invite user</h4>
    </div> --}}
    <div class="modal-body">
        <form action="{{url(test)}}">
            <label>user id</label>
            <input type="text" name="userid" id="userid" class="form-control"/>
            <label>Work Title : </label>
            <select>;
            foreach($work_titles as $i => $row){
                <option value=$row['work_title']>$row['work_title']</option>;
            }
            </select><br>
            <input type="submit" value="초대">
        </form>
    </div>
</div>
