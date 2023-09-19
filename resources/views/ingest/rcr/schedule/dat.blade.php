<html>
    <body>
        <form method="post">
            {{ csrf_field() }}
            <div><input style="width:250px; margin-bottom: 10px;" name="county"/></div>

            <div><input style="width:250px; margin-bottom: 10px;" name="name"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="editors"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="svO"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="svA"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="saO"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="saA"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="spO"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="spA"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="observers"/></div>
            <button>
Save
            </button>
        </form>
    </body>
</html>

