<html>
    <body>
        <form method="post">
            {{ csrf_field() }}
            <div>
                <input style="width:250px; margin-bottom: 10px;" name="primary1"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary2"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary3"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary4"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="primary5"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary6"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary7"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary8"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="primary9"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary10"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary11"/>
                <input style="width:250px; margin-bottom: 10px;" name="primary12"/>
            </div>

            <hr />

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="backup1"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup2"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup3"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup4"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="backup5"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup6"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup7"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup8"/>
            </div>

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="backup9"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup10"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup11"/>
                <input style="width:250px; margin-bottom: 10px;" name="backup12"/>
            </div>

            <hr />

            <div>
                <input style="width:250px; margin-bottom: 10px;" name="supervisor1"/>
                <input style="width:250px; margin-bottom: 10px;" name="supervisor2"/>
                <input style="width:250px; margin-bottom: 10px;" name="supervisor3"/>
            </div>

            <button>
Save
            </button>
        </form>
    </body>
</html>
