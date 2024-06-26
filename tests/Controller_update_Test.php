<?php
use PHPUnit\Framework\TestCase;
use Exam\Core\Controller;
use Exam\Core\Connect;
use Exam\Pages\Back\Dashboard;

class Controller_update_Test extends TestCase{
    protected static $controller;
    protected static $dashboard;
    private static $handler = null;

    public static function setUpBeforeClass():void{
        $connect=new Connect();
        self::$handler = $connect->getHandler();
    }
    protected function setUp():void
    {
        $this->delete_table();
        self::$controller = new Controller();
        self::$dashboard =new Dashboard();
        $this->insert_Users();
        // $this->insert_Courses();
        // $this->insert_timeslot();
        // $this->insert_coursetimeslots();
        // $this->insert_timetable();
    }
    private function delete_table()
    {
        $need_table=["TimeTable","CourseTimeSlots","TimeSlot","Course","Users"];
        foreach($need_table as $table)
        {
            if(!$this->table_Exists($table))
            {
                continue;
            }
            self::$handler->exec("DROP TABLE `$table`");
        }
    }
    private function table_Exists($table)
    {
        $stmt = self::$handler->query("SHOW TABLES LIKE '$table'");
        return !($stmt->rowCount() == 0);
    }
    private function insert_Users(){
        $password = password_hash("12345678", PASSWORD_DEFAULT);
        self::$controller->insert_User("test_user",$password);
    }
    // private function insert_Courses(){
    //     $sql = "INSERT INTO Course (ID, Name, cls_name, dept,request , Credits,CurrentPeople,MaxPeople) VALUES 
    //         (1312, '系統程式','資訊二乙','資訊系',1, 3,20,30),
    //         (1314, '機率與統計','資訊二乙','資訊系',1, 3,30,30),
    //         (1313, '資料庫系統','資訊二乙','資訊系',1, 3,40,30),
    //         (2864, '日文(一)','資訊二乙','資訊系',0, 2,0,30),
    //         (1311, '班級活動','資訊二乙','資訊系',1, 0,0,30),
    //         (1324, 'Web程式設計','資訊二乙','資訊系',0, 3,0,30),
    //         (2990, '漢字之美','資訊二乙','資訊系',0, 2,0,30),
    //         (1365, '程式設計與問題解決','資訊二乙','資訊系',0, 2,0,30),
    //         (2809, '華語教材教法','資訊二乙','資訊系',0, 2,0,30),
    //         (3320, '大學精進英文(二)中級','資訊二乙','資訊系',1, 2,0,30)";
    //     $stmt = self::$handler->prepare($sql);
    //     $ret = $stmt->execute();
    //     if (!$ret) return false;
    // }
    private function insert_timeslot(){
        $sql = "INSERT INTO TimeSlot (time_slot_id, day, start_time,end_time) VALUES 
            (1, '星期一', '10:10:00', '12:00:00'),
            (2, '星期三', '11:10:00', '12:00:00'),
            (3, '星期一', '13:10:00', '15:00:00'),
            (4, '星期二', '11:10:00', '12:00:00'),
            (5, '星期一', '15:10:00', '17:00:00'),
            (6, '星期二', '10:10:00', '11:00:00'),
            (7, '星期二', '13:10:00', '15:00:00'),
            (8, '星期二', '16:10:00', '17:00:00'),
            (9, '星期三', '08:10:00', '11:00:00'),
            (10, '星期四', '10:10:00', '12:00:00'),
            (11, '星期四', '13:10:00', '15:00:00'),
            (12, '星期四', '18:30:00', '20:15:00'),
            (13, '星期五', '08:10:00', '10:00:00')";
        $stmt = self::$handler->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) return false;
    }

    private function insert_coursetimeslots(){
        $sql = "INSERT INTO CourseTimeSlots (Course_ID, Time_Slot_ID) VALUES 
            (1312,1),(1312,2),
            (1314,3),(1314,4),
            (1313,5),(1313,6),
            (2864,7),
            (1311,8),
            (1324,9),
            (2990,10),
            (1365,11),
            (2809,12),
            (3320,13)";
        $stmt = self::$handler->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) return false;
}

    private function insert_timetable(){
        $sql = "INSERT INTO TimeTable (course_ID, time_slot_id, user_id) VALUES 
            (1312,1,1),(1312,2,1),
            (2864,7,1),
            (1311,8,1),
            (2809,12,1)";
        $stmt = self::$handler->prepare($sql);
        $ret = $stmt->execute();
        if (!$ret) return false;
    }

    // public function testSearch(){
    //     $result1= self::$controller->search_User_TimeTable('test_user',1312);
    //     $this->assertTrue($result1);

    //     $result2= self::$controller->search_User_TimeTable('test_user',1311);
    //     $this->assertTrue($result2);
    // }
    // public function testDisplayUserTimeTable(){
    //     $result = self::$controller->display_User_TimeTable('test_user');
    //     $expected = [
    //         ["Name"=>"系統程式","day"=>"星期一","start_time"=>"10:10:00","end_time"=>"12:00:00"],
    //         ["Name"=>"系統程式","day"=>"星期三","start_time"=>"11:10:00","end_time"=>"12:00:00"],
    //         ["Name"=>"日文(一)","day"=>"星期二","start_time"=>"13:10:00","end_time"=>"15:00:00"],
    //         ["Name"=>"班級活動","day"=>"星期二","start_time"=>"16:10:00","end_time"=>"17:00:00"],
    //         ["Name"=>"華語教材教法","day"=>"星期四","start_time"=>"18:30:00","end_time"=>"20:15:00"]
    //     ];
    //     $this->assertEquals($expected,$result);
    // }
    //public function testUpdate(){
        // $result1=self::$controller->updateCourse(1312,'MaxPeople',30);
        // $this->assertTrue($result1);
        // $result3=self::$controller->updateCourse(1312,'Name','系統程式W');
        // $this->assertTrue($result3);

        // $courseInfo = $this->CourseInfo(1312);
        // $this->assertEquals(30, $courseInfo['MaxPeople']);
        // $courseInfo = $this->CourseInfo(1312);
        // $this->assertEquals('系統程式W', $courseInfo['Name']);

        // $result2=self::$controller->updateTimeSlots(6, '星期二', '10:30:00','11:00:00');
        // $this->assertTrue($result2);
        // $this->assertTrue(self::$controller->update_User_dept("test_user","Computer_Science"));
        // $this->assertTrue(self::$controller->update_User_TotalCerdits("test_user"));

        // $result4=self::$controller->updateCourseTimeSlots(1312,3);
        // $this->assertTrue($result4);

        // $result5=self::$controller->check_people_number(1312) ;
        // $this->assertTrue($result5);

        // $result6=self::$controller->check_people_number(1313) ;
        // $this->assertTrue($result6);

        // $result7=self::$controller->check_people_number(1314) ;
        // $this->assertTrue($result7);

        
    //}

    /*public function testAlert(){
        self::$controller->updateTotalCredits('test_user',29);
        if(self::$controller->insert_check_Credits(1247,'test_user')){  
            $this->assertTrue(self::$controller-> insert_TimeTable(1247,1,2));
        }
        else {

        }
        self::$dashboard->alarm_total_credits();

        $_SESSION['Course_ID'] = 123; 
        $_SESSION['Name'] = 'test_user'; 
    
        // 將警報消息存儲在一個變量中而不是直接 echo
        ob_start();
        self::$dashboard->alarm_total_credits();
        $alertMessage = ob_get_clean(); // 獲取緩衝區內容並清空緩衝區
    
        $expectedMessage = "alert('無法加選，加選後學分將高於最高30學分')";
        $this->assertContains($expectedMessage, $alertMessage);
    }*/


    public function CourseInfo(int $ID): bool|array
    {
        $sql = "SELECT * FROM Course WHERE ID = ?";
        $stmt = self::$handler->prepare($sql);
        $ret = $stmt->execute([$ID]);
        if(!$ret ) return false;
        return $stmt->fetch();
    }
    public function tearDown(): void { 
        $this->delete_table();
    }
    public static function tearDownAfterClass(): void{
        self::$controller=null;
        self::$handler=null;
    }
}
