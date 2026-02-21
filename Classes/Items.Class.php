<?php
include_once __DIR__ . '/Dbh.Class.php';

class Items extends Dbh {

    /*
      PROTECTED FUNCTIONS FOR ITEMS MANAGEMENT
      Exclusive to subclass for this class
    */

    // Count low stock products
    protected function countLowStocks($userID){
        
        $lowStockLimit = 5;

        $query = "
            SELECT COUNT(*) AS low_stock_count
            FROM inventory
            WHERE USER_ID = ?
            AND QUANTITY <= ?
            AND IS_ACTIVE = 1
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID, $lowStockLimit])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['low_stock_count'];
    }

    // Count out of stock products
    protected function countOutOfStocks($userID){
        
        $StockLimit = 0;

        $query = "
            SELECT COUNT(*) AS out_of_stock_count
            FROM inventory
            WHERE USER_ID = ?
            AND QUANTITY = ?
            AND IS_ACTIVE = 1
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID, $StockLimit])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['out_of_stock_count'];
    }

    // Count pending products
    protected function countPending($userID){
        
        $query = "
            SELECT COUNT(*) AS pending_count
            FROM reservation
            WHERE USER_ID = ?
            AND STATUS = 'On Process'
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['pending_count'];
    }

    // Count reserved products
    protected function countReserved($userID){

        $query = "
            SELECT COUNT(*) AS reserved_count
            FROM reservation
            WHERE USER_ID = ?
            AND STATUS = 'Reserved'
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$userID])) {
            return 0;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['reserved_count'];
    }

    // Get all items from inventory table
    protected function getInventory($userID) {
        $orgID = $this->getOrganizationID($userID);

        // Check if user belongs to an organization
        if($orgID){

            $query = "SELECT * FROM inventory WHERE ORGANIZATION_ID = ? AND IS_ACTIVE = 1";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$orgID])) {
                return false;
            }

        }else{

            $query = "SELECT * FROM inventory WHERE USER_ID = ? AND IS_ACTIVE = 1";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$userID])) {
                return false;
            }
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all items from reservation table
    protected function getReservations($userID) {

        $orgID = $this->getOrganizationID($userID);

        // Check if user belongs to an organization
        if($orgID){

            $query = "SELECT * FROM reservation WHERE ORGANIZATION_ID = ? AND IS_ACTIVE = 1";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$orgID])) {
                return false;
            }

        }else{

            $query = "SELECT * FROM reservation WHERE USER_ID = ? AND IS_ACTIVE = 1";
            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$userID])) {
                return false;
            }
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get all stocks from stocks table
    protected function getStocks($userID) {

        $orgID = $this->getOrganizationID($userID);

        // Check if user belongs to an organization
        if($orgID){

            $query = "
                    SELECT
                        s.STOCKS_ID,
                        s.ORGANIZATION_ID,
                        s.MATERIAL_NAME,
                        s.USER_ID,
                        s.SOURCE_TABLE,
                        s.SOURCE_ID,
                        s.QUANTITY,
                        s.TRANSACTION_TYPE,
                        s.TIME_AND_DATE,
                        (s.QUANTITY * i.PRICE) AS TOTAL_PRICE
                    FROM stocks_log s
                    LEFT JOIN inventory i
                        ON s.MATERIAL_NAME = i.MATERIAL_NAME
                        AND i.IS_ACTIVE = 1
                    WHERE s.ORGANIZATION_ID = ?
                    ";
            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$orgID])) {
                return false;
            }

        }else{

            $query = "
                    SELECT
                        s.STOCKS_ID,
                        s.MATERIAL_NAME,
                        s.USER_ID,
                        s.SOURCE_TABLE,
                        s.SOURCE_ID,
                        s.QUANTITY,
                        s.TRANSACTION_TYPE,
                        s.TIME_AND_DATE,
                        (s.QUANTITY * i.PRICE) AS TOTAL_PRICE
                    FROM stocks_log s
                    LEFT JOIN inventory i
                        ON s.MATERIAL_NAME = i.MATERIAL_NAME
                        AND i.IS_ACTIVE = 1
                    WHERE s.USER_ID = ?
                    ";
            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$userID])) {
                return false;
            }
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert new item to inventory
    protected function insertItem($userID, $materialName, $quantity, $price, $description) {

        $orgID = $this->getOrganizationID($userID);

        // Check if user belongs to an organization
        if($orgID){

            $query = "
                INSERT INTO inventory (USER_ID, ORGANIZATION_ID, MATERIAL_NAME, QUANTITY, PRICE, DESCRIPTION)
                VALUES (?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$userID, $orgID, $materialName, $quantity, $price, $description])) {
                return false;
            }

        }else{
            $orgID = null;

            $query = "
                INSERT INTO inventory (USER_ID, ORGANIZATION_ID, MATERIAL_NAME, QUANTITY, PRICE, DESCRIPTION)
                VALUES (?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$userID, $orgID, $materialName, $quantity, $price, $description])) {
                return false;
            }
        }

        $sourceID = $this->connection()->lastInsertId();
        $type = "INSERTED ITEM";

        // Log stock addition
        $this->logStockChange($orgID, $materialName, $userID, 'inventory', $sourceID, $quantity, $type);

        return true;
    }

    // Insert new reservation
    protected function insertReservation($materialID, $userID, $quantity, $requestor, $remarks, $claimDate) {

            $orgID = $this->getOrganizationID($userID);

        // Check if user belongs to an organization
        if($orgID){

            $query = "
                INSERT INTO reservation (MATERIAL_ID, USER_ID, ORGANIZATION_ID, QUANTITY, REQUESTOR, PURPOSE, CLAIMING_DATE)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$materialID, $userID, $orgID, $quantity, $requestor, $remarks, $claimDate])) {
                return false;
            }

        }else{
            $orgID = null;

            $query = "
                INSERT INTO reservation (MATERIAL_ID, USER_ID, ORGANIZATION_ID, QUANTITY, REQUESTOR, PURPOSE, CLAIMING_DATE)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

            $stmt = $this->connection()->prepare($query);

            if (!$stmt->execute([$materialID, $userID, $orgID, $quantity, $requestor, $remarks, $claimDate])) {
                return false;
            }
        }

        $sourceID = $this->connection()->lastInsertId();

        // Fetch the material name from inventory
        $stmt2 = $this->connection()->prepare("SELECT MATERIAL_NAME FROM inventory WHERE MATERIAL_ID = ?");

        if(!$stmt2->execute([$materialID])){
            return false;
        }
    
        $materialName = $stmt2->fetch(PDO::FETCH_ASSOC)['MATERIAL_NAME'] ?? 'Unknown';

        $type = "ON PROCESS ITEM";
        

        // Log stock reservation
        $this->logStockChange($orgID, $materialName, $userID, 'reservation', $sourceID, $quantity, $type);

        return true;
    }

    // Update existing item in inventory
    protected function updateItemDB($materialName, $quantity, $price, $description, $ID) {

        $query = "
            UPDATE inventory
            SET MATERIAL_NAME = ?, QUANTITY = ?, PRICE = ?, DESCRIPTION = ?
            WHERE MATERIAL_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$materialName, $quantity, $price, $description, $ID])) {
            return false;
        }

        return true;
    }

    // Update Reservation Status
    protected function updateReservationStatusDB($reservationID, $status) {

        // Update reservation status
        $query = "
            UPDATE reservation
            SET STATUS = ?
            WHERE RESERVATION_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);
        if (!$stmt->execute([$status, $reservationID])) {
            return false;
        }

        // Only adjust inventory for these statuses
        if (!in_array($status, ['RESERVED', 'CANCELLED'])) {
            return true;
        }

        // Fetch stock log data
        $stockRecord = $this->fetchStockData($reservationID);
        if (!$stockRecord) {
            return false;
        }

        $quantity   = (int)$stockRecord['QUANTITY'];
        $materialID = $this->getMaterialIDReservation($reservationID);

        if (!$materialID) {
            return false;
        }

        // RESERVED → subtract stock
        if ($status === 'RESERVED') {
            $this->updateQuantity(-$quantity, $materialID);
        }

        // CANCELLED → restore stock
        if ($status === 'CANCELLED') {
            $this->updateQuantity($quantity, $materialID);
        }

        // Log the stock change
        $this->logStockChange(
            $stockRecord['ORGANIZATION_ID'],
            $stockRecord['MATERIAL_NAME'],
            $stockRecord['USER_ID'],
            'reservation',
            $reservationID,
            $quantity,
            "STATUS UPDATED TO $status"
        );

        return true;
    }


        

    // Delete existing item in inventory
    protected function deleteItemDB($ID) {

        $query = "
            UPDATE inventory
            SET IS_ACTIVE = 0
            WHERE MATERIAL_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$ID])) {
            return false;
        }

        return true;
    }

    // Delete existing reservation in inventory
    protected function deleteReservationDB($ID) {

        $query = "
            UPDATE reservation
            SET IS_ACTIVE = 0
            WHERE RESERVATION_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$ID])) {
            return false;
        }

        return true;
    }

    /*
      PRIVATE FUNCTIONS FOR STOCK LOGGING
      Exclusive to this class
    */

    // Private function to log stock changes
    private function logStockChange($orgID, $materialName, $userID, $sourceTable, $sourceID, $quantity, $transactionType) {

        $query = "
            INSERT INTO stocks_log (ORGANIZATION_ID, MATERIAL_NAME, USER_ID, SOURCE_TABLE, SOURCE_ID, QUANTITY, TRANSACTION_TYPE)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$orgID, $materialName, $userID, $sourceTable, $sourceID, $quantity, $transactionType])) {
            return false;
        }

        return true;
    }

    // Private function to fetch stock data by reservation ID
    private function fetchStockData($reservationID) {

        $query = "
            SELECT * FROM stocks_log
            WHERE SOURCE_ID = ? AND SOURCE_TABLE = 'reservation'
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$reservationID])) {
            return false; // query failed
        }

        // Fetch the first matching record
        $stockData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stockData ?: null; // return null if no record found
    }

    // Private function to update quantity in inventory after logging
    // $delta can be positive (add) or negative (subtract)
    private function updateQuantity($delta, $materialID){
        $query = "
            UPDATE inventory
            SET QUANTITY = QUANTITY + ?
            WHERE MATERIAL_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);
        return $stmt->execute([$delta, $materialID]);
    }

    // Private function to get material ID from reservation ID
    private function getMaterialIDReservation($reservationID){
        $query = "
            SELECT MATERIAL_ID
            FROM reservation
            WHERE RESERVATION_ID = ?
        ";

        $stmt = $this->connection()->prepare($query);

        if (!$stmt->execute([$reservationID])) {
            return false;
        }

        return (int) $stmt->fetch(PDO::FETCH_ASSOC)['MATERIAL_ID'];
    }

    // Private function to get organization ID from user ID
    private function getOrganizationID($userID){
        $query = "
            SELECT o.ORGANIZATION_ID
            FROM organizations o
            LEFT JOIN members m ON o.ORGANIZATION_ID = m.ORGANIZATION_ID
            WHERE o.USER_ID = ? OR m.USER_ID = ?
            LIMIT 1
        ";

        $stmt = $this->connection()->prepare($query);
        if (!$stmt->execute([$userID, $userID])) {
            return null;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['ORGANIZATION_ID'] ?? null;
    }


}
