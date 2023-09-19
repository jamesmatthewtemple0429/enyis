<html>
    <body>
        <form method="post">
            {{ csrf_field() }}
            <div>
                <input style="width:250px; margin-bottom: 10px;" name="date1"/>
                <input style="width:250px; margin-bottom: 10px;" name="name1"/>
                <input style="width:250px; margin-bottom: 10px;" name="summary1"/>
                <input style="width:250px; margin-bottom: 10px;" name="county1"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="date2"/>
                <input style="width:250px; margin-bottom: 10px;" name="name2"/>
                <input style="width:250px; margin-bottom: 10px;" name="summary2"/>
                <input style="width:250px; margin-bottom: 10px;" name="county2"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="date3"/>
                <input style="width:250px; margin-bottom: 10px;" name="name3"/>
                <input style="width:250px; margin-bottom: 10px;" name="summary3"/>
                <input style="width:250px; margin-bottom: 10px;" name="county3"/>
            </div>




            <button>
Save
            </button>
        </form>
    </body>
</html>



