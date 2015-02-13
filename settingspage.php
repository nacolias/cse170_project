    <div class="row">
        <center><h1>General Settings</h1></center>
    </div>

    <div class="form">
      <div class="row">
        <div class="small-10 small-centered columns person">
          <center><h4>Availability</h4></center>
          <br />
          <br />

          <center>
            <input id="sunday"type="checkbox" value=""><label for="Sunday"><span>S</span></label>
            <input id="monday"type="checkbox" value=""><label for="Monday"><span>M</span></label>
            <input id="tuesday"type="checkbox" value=""><label for="Tuesday">T</label>
            <input id="wednesday"type="checkbox" value=""><label for="Wednesday">W</label>
            <input id="thursday" type="checkbox" value=""><label for="Thursday">T</label>
            <input id="friday"type="checkbox" value=""><label for="Friday">F</label>
            <input id="saturday" type="checkbox" value=""><label for="Saturday">S</label>
          </center>

          <br />
          <div class="row">
            <div class="small-12 small-centered columns">
             <div class="small-6 columns">
                <input id="starttime" type="time" placeholder="Start Time" />
              </div>

              <div class="small-6 columns">
                <input id="endtime" type="time" placeholder="End Time" />
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="small-centered small-10 columns buttonarea">
                <center>
                    <a href="#" class="small left button">View Current</a>
                    <div id="submittime" action"" class="small right button">Submit</a>
                </center>
            </div>
        </div>

        </div>
      </div>
    </div>

    <div class="row">
      <a href="setup.php">
       <div class="columns small-8 small-centered person">
            <center><h4>Edit Profile Settings</h4></center>
       </div>
      </a>
    </div>

    <div class="row">
      <a href="logout.php">
       <div class="columns small-8 small-centered person">
            <center><h4>Logout</h4></center>
       </div>
      </a>
    </div>