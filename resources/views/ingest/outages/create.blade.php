<html>
    <body>
        <form method="post">
            {{ csrf_field() }}
            <div>
                <input style="width:250px; margin-bottom: 10px;" name="county"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="company1"/>
                <input style="width:250px; margin-bottom: 10px;" name="affected1"/>
                <input style="width:250px; margin-bottom: 10px;" name="total1"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="company2"/>
                <input style="width:250px; margin-bottom: 10px;" name="affected2"/>
                <input style="width:250px; margin-bottom: 10px;" name="total2"/>
            </div>


            <div>
                <input style="width:250px; margin-bottom: 10px;" name="company3"/>
                <input style="width:250px; margin-bottom: 10px;" name="affected3"/>
                <input style="width:250px; margin-bottom: 10px;" name="total3"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="company4"/>
                <input style="width:250px; margin-bottom: 10px;" name="affected4"/>
                <input style="width:250px; margin-bottom: 10px;" name="total4"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="company5"/>
                <input style="width:250px; margin-bottom: 10px;" name="affected5"/>
                <input style="width:250px; margin-bottom: 10px;" name="total5"/>
            </div>



            <button>
Save
            </button>
        </form>
    </body>
</html>
