<?php

class BSQ
{
    public function __construct($file)
    {
        $this->file = $file;
        $this->nbLines = 0;
        $this->map = [];
        $this->rowLength = 0;
        $this->binBoard = [];
        $this->dataMaxSquare = [];
    }

    public function main()
    {
        $handle = fopen($this->file, 'r');
        if ($handle) {

            $this->nbLines = fgets($handle);
            while ($line = fgets($handle)) {
                $this->map[] = trim($line);
            }
            $this->rowLength = strlen($this->map[0]);

            $this->createBinBoard();
            $this->findMaxSquare();
            $this->displaySquare();

            foreach ($this->map as $row) {
                echo "$row\n";
            }
        }
        fclose($handle);
    }

    private function createBinBoard()
    {
        foreach ($this->map as $row) {
            for ($i = 0; $i < $this->rowLength; $i++) {
                if ($row[$i] == ".") {
                    $row[$i] = '1';
                } else {
                    $row[$i] = '0';
                }
            }
            $this->binBoard[] = $row;
        }
    }

    private function findMaxSquare()
    {
        $rowId = 0;
        $maxSquareSize = 0;

        foreach ($this->binBoard as $row) {
            for ($i = 0; $i < $this->rowLength; $i++) {

                if (isset($this->binBoard[$rowId - 1][$i - 1])) {
                    $topLeft = $this->binBoard[$rowId - 1][$i - 1];
                    $topLeft = intval($topLeft);
                } else {
                    $topLeft = 0;
                }

                if (isset($this->binBoard[$rowId - 1][$i])) {
                    $top = $this->binBoard[$rowId - 1][$i];
                    $top = intval($top);
                } else {
                    $top = 0;
                }

                if (isset($this->binBoard[$rowId][$i - 1])) {
                    $left = $this->binBoard[$rowId][$i - 1];
                    $left = intval($left);
                } else {
                    $left = 0;
                }

                if ($row[$i] != 0) {
                    $this->binBoard[$rowId][$i] = min([$topLeft, $top, $left]) + $row[$i];
                } else {
                    $this->binBoard[$rowId][$i] = 0;
                }

                if ($maxSquareSize < $this->binBoard[$rowId][$i]) {
                    $maxSquareSize = $this->binBoard[$rowId][$i];
                    $x = $i;
                    $y = $rowId;
                }
            }
            $rowId++;
        }
        return $this->dataMaxSquare =  [$maxSquareSize, $x, $y];
    }

    private function displaySquare()
    {
        for ($i = 0; $i < $this->dataMaxSquare[0]; $i++) {
            for ($j = 0; $j < $this->dataMaxSquare[0]; $j++) {
                $this->map[$this->dataMaxSquare[2] - $i][$this->dataMaxSquare[1] - $j] = 'x';
            }
        }
    }
}

$BSQ = new BSQ($argv[1]);
$BSQ->main();
