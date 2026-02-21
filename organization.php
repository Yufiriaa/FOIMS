<?php
    session_start(); 

    if(!isset($_SESSION['USER_ID'])){
        header('Location: ./index.php');
        exit();
    }   

?>
<body>
    <!--Important import files-->
    <?php
        include __DIR__ . "/Inclusions/Head.php";
        //include __DIR__ . "/Inclusions/navbar.php";
        include __DIR__ . "/Inclusions/Methods.php";
        include __DIR__ . "/Classes/Dbh.Class.php";
        include __DIR__ . "/Classes/OrganizationCntrl.Class.php";
        include __DIR__ . "/Classes/OrganizationView.Class.php";

        // Scripts
        include __DIR__ . '/Scripts/mainScript.php';

        $organizationView = new OrganizationView();
        $USER_ID = $_SESSION['USER_ID'];
        $organizations = $organizationView->viewOrganizations();
        $members = $organizationView->viewMembers();
    ?>

    <!--Main Body for Organization Page, 2 Columns-->
    <div id="BodyDiv" class="w-full min-h-screen flex bg-[D0DACA] text-[1F2933] ">

        <div class="w-1/5">
            <!--Sidebar from import-->
            <?php
                include __DIR__ . "/Inclusions/sidebar.php";
            ?>
        </div>

        <!--Parts Organization-->
        <div class="w-full flex flex-col gap-5">

            <!--NavBar-->
            <div>
                <?php include __DIR__ . "/Inclusions/navbar.php";?>
            </div>

            <!--Message Panel-->
            <?php renderFlashBox(); ?>

            <div class="grid gap-1 w-full h-20 my-2 px-5 flex items-center">
                <h1 class="text-3xl font-bold">Organizations</h1>
                <p class="font-medium text-sm">Make you contributions or create one today!</p>
            </div>

            <!--Indicators-->
            <div class="flex px-5 justify-start gap-5">

                <!--Create Organization Modal-->
                <div id="showCreateOrganization" class="w-1/5 h-15 bg-[D0DACA] border border-[1F2933] shadow-sm flex">
                    <div class="w-70 flex justify-center items-center gap-3 hover:cursor-pointer">
                        <i class="fa fa-plus-circle text-xl"></i>
                        <p class="text-sm">Create an Organization</p>
                    </div>
                </div>

                <!--Leave Organization Modal-->
                <div id="showLeaveOrganization" class="w-1/5 h-15 bg-[D0DACA] border border-[1F2933] shadow-sm flex">
                    <div class="w-70 flex justify-center items-center gap-3 hover:cursor-pointer">
                        <i class="fa fa-minus-circle text-xl"></i>
                        <p class="text-sm">Leave Organization</p>
                    </div>
                </div>

                <!-- Organization Creation Modal -->
                <dialog id="organizationCreationEntry" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-1/3 p-6 border shadow-xl bg-[C7CFBE] text-[1F2933] backdrop:bg-black/40 open:animate-fadeIn">
                    <form method="POST" action="./Process/OrganizationProcess/addOrganization.php" class="space-y-6">

                        <!-- Modal Title -->
                        <h1 class="text-2xl font-bold">Organization FORM</h1>

                        <!-- Organization Name -->
                        <div class="space-y-2">
                        <label class="block text-md font-medium ">Name</label>
                        <input required type="text" placeholder="my organiazation" class="w-full p-3 text-md border border-gray-300 rounded-md" name="organizationName"/>
                        </div>

                        <!-- Address -->
                        <div class="space-y-2">
                        <label class="block text-md font-medium ">Address</label>
                        <input required type="text" placeholder="N/A" class="w-full p-3 text-md border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="organizationAddress"/>
                        </div>

                        <!-- Type -->
                        <div class="space-y-2">
                        <label class="block text-md font-medium">Type (School, Office, etc.)</label>
                        <input required type="text" placeholder="N/A" class="w-full p-3 text-md border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="organizationType"/>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('organizationCreationEntry').close()" class="px-4 py-2 cursor-pointer bg-white font-semibold rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" name="addBtn" class="px-4 py-2 cursor-pointer bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">Save</button>
                        </div>
                        
                    </form>
                </dialog>

                <!-- Organization Leave Modal -->
                <dialog id="organizationLeave" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-1/3 p-6 shadow-xl bg-[C7CFBE] border text-[1F2933] backdrop:bg-black/40 open:animate-fadeIn">
                    <form method="POST" action="./Process/OrganizationProcess/leaveOrganization.php" class="space-y-6">

                        <!-- Modal Title -->
                        <h1 class="text-2xl font-bold">LEAVE FORM</h1>

                        <!-- Organization Name -->
                        <p class="text-xl font-semi">Are you sure you want to leave this organization?</p>

                        <!-- Remarks -->
                        <div class="space-y-2">
                        <label class="block text-md font-medium">Remarks</label>
                        <input required type="text" placeholder="N/A" class="w-full p-3 text-md border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" 
                         name="remarks"/>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="document.getElementById('organizationLeave').close()" class="px-4 py-2 cursor-pointer bg-white font-semibold rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" name="addBtn" class="px-4 py-2 cursor-pointer bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">Submit</button>
                        </div>
                        
                    </form>
                </dialog>

            </div>

            <!-- Tables Toggle-->
            <div class="flex gap-3 text-sm px-5 mt-5 -mb-5">
                <button id="showorganizationTable" class="cursor-pointer px-3 py-1 text-white hover:text-white border "><p>Organizations</p></button>
                <button id="showmyorganizationTable" class="cursor-pointer px-3 py-1 hover:text-white border"><p>My Organization</p></button>
            </div>

            <!--Organization Tables-->
            <div id="organizationTablecon" class="h-full w-full px-5">

                <table id="organizationTable" class="table-auto bg-[C7CFBE] border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-md">
                            <th class="w-md  text-[1F2933]">NAME</th>
                            <th class="w-md  text-[1F2933]">ADDRESS</th>
                            <th class="w-md  text-[1F2933]">TYPE</th>
                            <th class="w-md  text-[1F2933]">DATE CREATED</th>
                            <th class="w-md  text-[1F2933]">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($organizations as $row): ?>
                            <tr class="odd:bg-[C7CFBE] even:bg-[bdc3b2] text-[1F2933] border border-0 h-10 text-sm">
                                <td><?= htmlspecialchars($row['NAME']) ?></td>
                                <td><?= htmlspecialchars($row['ADDRESS']) ?></td>
                                <td><?= htmlspecialchars($row['TYPE']) ?></td>
                                <td><?= htmlspecialchars(date('F j, Y', strtotime($row['CREATED_AT']))) ?></td>
                                <td>
                                    <div class="flex justify-center items-center gap-5 text-lg">
                                        <div class="cursor-pointer text-[1F2933]" onclick="document.getElementById('updateModal<?= $row['ORGANIZATION_ID'] ?>').showModal()">
                                            <i class="fa fa-pencil text-lg"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Update Modal -->
                            <dialog id="updateModal<?= $row['ORGANIZATION_ID'] ?>" 
                                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl bg-[C7CFBE] text-[1F2933] backdrop:bg-black/40 open:animate-fadeIn">

                                <form method="POST" action="./Process/OrganizationProcess/enterOrganization.php" class="space-y-6">
                                    
                                    <!-- Modal Title -->
                                    <h1 class="text-2xl font-bold mb-1">APPLICATION FORM</h1>

                                    <!-- Remarks -->
                                    <div class="space-y-3">
                                        <label class="block text-md font-medium ">Remarks</label>
                                        <input type="text" name="remarks" placeholder="Enter your reason here"
                                            class="w-full p-3 text-md border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                    </div>

                                    <!-- Hidden Organization ID -->
                                    <input type="hidden" name="organizationId" value="<?= htmlspecialchars($row['ORGANIZATION_ID'])?>">

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-3 pt-4">
                                        <button type="button" 
                                            onclick="document.getElementById('updateModal<?= $row['ORGANIZATION_ID'] ?>').close()" 
                                            class="px-4 py-2 cursor-pointer bg-gray-200 font-semibold rounded hover:bg-gray-300">
                                            Cancel
                                        </button>
                                        <button type="submit" name="updateBtn" 
                                            class="px-4 py-2 cursor-pointer bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                                            Submit
                                        </button>
                                    </div>

                                </form>
                            </dialog>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

            <!--My Organization Tables-->
            <div id="myorganizationTableconOWNER" class="hidden h-full w-full px-5">

                <table id="myorganizationTable" class="table-auto bg-[C7CFBE] border-separate border h-fit max-h-full">
                    <thead>
                        <tr class="text-md">
                            <th class="w-md  text-[1F2933]">NAME</th>
                            <th class="w-md  text-[1F2933]">REMARKS</th>
                            <th class="w-md  text-[1F2933]">DATE JOINED</th>
                            <th class="w-md  text-[1F2933]">ACTIVE</th>
                            <th class="w-md  text-[1F2933]">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $row): ?>
                            <tr class="odd:bg-[C7CFBE] even:bg-[bdc3b2] text-[1F2933] border border-0 h-10 text-sm">
                                <td><?= htmlspecialchars($row['NAME']) ?></td>
                                <td><?= htmlspecialchars($row['REMARKS']) ?></td>
                                <td><?= htmlspecialchars(date('F j, Y', strtotime($row['DATE_JOINED']))) ?></td>
                                <td><?= htmlspecialchars($row['IS_ACTIVE'] == 0 ? 'No' : 'Yes') ?></td>
                                <td>
                                    <div class="flex justify-center items-center gap-5 text-lg">
                                        <div class="cursor-pointer text-[1F2933]" onclick="document.getElementById('updateModal2<?= $row['MEMBER_ID'] ?>').showModal()">
                                            <i class="fa fa-pencil text-lg"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Update Modal -->
                            <dialog id="updateModal2<?= $row['MEMBER_ID'] ?>" 
                                class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[36rem] max-w-full p-6 rounded-lg shadow-xl bg-[C7CFBE] text-[1F2933] backdrop:bg-black/40 open:animate-fadeIn">

                                <form method="POST" action="./Process/OrganizationProcess/updateStatus.php" class="space-y-6">
                                    
                                    <!-- Modal Title -->
                                    <h1 class="text-2xl font-bold mb-1">Update Application</h1>

                                    <!-- Name -->
                                    <div class="space-y-2">
                                        <label class="block text-md font-medium">Name</label>
                                        <input
                                            disabled
                                            type="text"
                                            name="name"
                                            value="<?= htmlspecialchars($row['NAME']) ?>"
                                            class="w-full p-3 text-md border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                                        />
                                    </div>

                                    <!-- Status -->
                                    <div class="space-y-2 mt-4">
                                        <label class="block text-md font-medium">Status</label>

                                        <div class="flex items-center gap-6">
                                            <label class="flex items-center gap-2">
                                                <input
                                                    type="radio"
                                                    name="is_active"
                                                    value="1"
                                                    <?= $row['IS_ACTIVE'] == 1 ? 'checked' : '' ?>
                                                >
                                                Active
                                            </label>

                                            <label class="flex items-center gap-2">
                                                <input
                                                    type="radio"
                                                    name="is_active"
                                                    value="0"
                                                    <?= $row['IS_ACTIVE'] == 0 ? 'checked' : '' ?>
                                                >
                                                Not Active
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Hidden Member ID -->
                                    <input type="hidden" name="memberId" value="<?= htmlspecialchars($row['MEMBER_ID'])?>">

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-3 pt-4">
                                        <button type="button" 
                                            onclick="document.getElementById('updateModal2<?= $row['MEMBER_ID'] ?>').close()" 
                                            class="px-4 py-2 cursor-pointer bg-gray-200 font-semibold rounded hover:bg-gray-300">
                                            Cancel
                                        </button>
                                        <button type="submit" name="updateBtn" 
                                            class="px-4 py-2 cursor-pointer bg-blue-500 text-white font-semibold rounded hover:bg-blue-600">
                                            Save
                                        </button>
                                    </div>

                                </form>
                            </dialog>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

            <!--No Access Message-->
            <div id="myorganizationTableconMEMBER" class="hidden w-full h-full flex justify-center items-center">
                <h1  class="text-xl font-bold">You must be an owner to view this page.</h1>
            </div>

        </div>

    </div>

</body>
