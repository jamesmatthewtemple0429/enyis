<html>
    <body>
        <form method="post">
            {{ csrf_field() }}
            <div><input style="width:250px; margin-bottom: 10px;" name="name"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="editors"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="primary"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="backup"/></div>
            <div><input style="width:250px; margin-bottom: 10px;" name="supervisor"/></div>


            <button>
Save
            </button>
        </form>
    </body>
</html>



