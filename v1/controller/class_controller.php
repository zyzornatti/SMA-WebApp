<?php

class TableContent {
  public $checker; //to check the name of the file wether its create or manage
  public $page; //to check the name of the page which will determine the name of the db table
  public $conn; //for db connection
  public $where; //for edit page to fetch record on a table
  private $sufix = ['panel', 'selection']; //suffix for read file

  private function fetch_all_tables(){ //fetch all tables in db
    $tabs = $this->conn->prepare("SHOW Tables FROM school");
    $tabs->execute();
    $tabss = $tabs->fetchAll();

    $tab = "Tables_in_school";
    $table_names = [];
    foreach ($tabss as $tables) {
      $table_names[] = checkIfReadOrPanel($tables[$tab]);
    }
    return $table_names;
  }

  public function table_name(){ //check if table name exist and return it, else return false

      $tt = [];
      //if its a create file, do this!!!
      if($this->checker == "create"){
        foreach ($this->sufix as $suf) {
          $tt[] = $suf."_".$this->page;
        }

        //check if table exist from all tables after suffix has been added to the page name
        if(in_array($tt[0], $this->fetch_all_tables())){
          return $tt[0];
        }elseif(in_array($tt[1], $this->fetch_all_tables())){
          return $tt[1];
        }else{
          return false; //table doesnt exist;
        }
      }

      //if its manage file, do this!!!
      if($this->checker == "manage" || $this->checker == "edit"){
        $this->sufix[] = "read"; //add read to suffix so it can fetch from table with read suffix
        foreach ($this->sufix as $suf) {
          $tt[] = $suf."_".$this->page;
        }

        //check if table exist from all tables after suffix has been added to the page name
        if(in_array($tt[0], $this->fetch_all_tables())){
          return $tt[0];
        }elseif(in_array($tt[1], $this->fetch_all_tables())){
          return $tt[1];
        }elseif(in_array($tt[2], $this->fetch_all_tables())){
          return $tt[2];
        }else{
          return false; //table doesn't exist
        }
      }

  }

  protected function table_columns(){ //fetch table columns
    if($this->table_name() == false){
      die("Error: table doesn't exist, hence cannot be fetched");
    }else{
      $table = $this->table_name();
    }

    $col = $this->conn->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = :tn");
    $col->bindParam(":tn", $table);
    $col->execute();

    $coll = $col->fetchAll();

    $dd = [];
    foreach ($coll as $columns) {
      $dd[] = $columns['COLUMN_NAME'];
    }

    return $dd;
  }

  public function filter_table_columns(){
    $col = $this->table_columns();
    $check = array_map("checkIfColVal", $col); //check for valid columns and fetch them
    $col_res = preg_grep('/ignore/', $check, PREG_GREP_INVERT); //ignore all invalid columns
    $columns = array_values($col_res); //all valid columns fetched
    return $columns;
  }

}

class TableRecord extends TableContent {

  public function filter_record_columns(){ //filter table columns for records: used for read_all
    $col = $this->table_columns();
    $col_res = array_map("checkIfColVal2", $col); //check for the valid columns that is readable
    $if_pass = preg_grep('/password/', $col_res, PREG_GREP_INVERT); //check if password column is among the columns and bring columns that is not password
    $columns = preg_grep('/ignore/', $if_pass, PREG_GREP_INVERT); //return all valid columns
    $ifs = array_map("checkIfSelect", $col_res);
    $if_sel = preg_grep('/ignore/', $ifs, PREG_GREP_INVERT); //fetch all select columns

    //fetch all select column names from their respective tables and save them in an array with hash_id as their keys
    if(count($if_sel) > 0){
      $sel_data[] = $if_sel;
      $so = [];
      $sel_col = [];
      foreach ($if_sel as $col) {
        $sel_col[] = "input_".selectTab($col);
        $so[] = fetchSelection($this->conn, $col);
      }
      $sel_data = [];
      for($i = 0; $i < count($if_sel); $i++){
        foreach ($so[$i] as $key => $value) {
          $sel_data[$value['hash_id']] = $value[$sel_col[$i]];
        }
      }

    }else{
      $sel_data = false;
    }

    // $data = [];
    // $data['columns'] = $columns;
    // $data['select_columns'] = $sel_data;
    $data = [
      'columns'=> $columns,
      'select_columns'=> $sel_data
    ];
    return $data;
    // return $columns;
  }

  public function table_record(){ //to fetch record for edit page
    $table = $this->table_name();
    return selectContent($this->conn, $table, $this->where);
  }

  public function table_records(){ //to fetch records for read_all
    $table = $this->table_name();
    return selectContent($this->conn, $table, []);
  }

  public function delete_record(){ //to fetch records for read_all
    $table = $this->table_name();
    return deleteContent($this->conn, $table, $this->where);
  }
}


 ?>
